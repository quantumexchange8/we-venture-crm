<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Commissions extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $guarded = [];
    public $sortable = [
        'lot_size',
        'commissions_amount',
        'transaction_at',
        'userId',
        'brokersId',
        'status'
    ];
    protected $casts = [
        'transaction_at' => 'datetime',
        'commissions_amount' => 'decimal:2',
        'lot_size' => 'decimal:2',
    ];

    const STATUS_PENDING = 1;
    const STATUS_CALCULATED = 2;

    public static function getActiveUserCommissionsRebateAmount()
    {
        $amount = self::with('user')->whereHas('user', function($q) {
            $q->where('status', User::STATUS_ACTIVE);
        })->sum('commissions_amount');

        return $amount;
    }

    public static function getMonthlyLotSize()
    {
        $start_date = Carbon::parse(Carbon::now()->startOfMonth())->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse(Carbon::now()->endOfMonth())->endOfDay()->format('Y-m-d H:i:s');
        $amount = self::with('user')->whereHas('user', function($q) {
            $q->where('status', User::STATUS_ACTIVE);
        })->whereBetween('transaction_at', [$start_date, $end_date])
            ->sum('lot_size');

        return $amount;
    }

    public static function getLotSizePool()
    {
        $worldPoolLatestDate = WorldPool::orderByDesc('to_time')->first();

        // Include both users with role 1 and role 0 in the query
        return self::with('user')->where(function ($query) {
            $query->whereHas('user', function ($q) {
                $q->where('status', User::STATUS_ACTIVE);
            })->orWhere('userId', 1);
        })->whereDate('transaction_at', '>',$worldPoolLatestDate->to_time)
            ->sum('lot_size');
    }

    public static function get_commissions_table($search, $userId, $children = [])
    {
        $query = Commissions::sortable();
        if (count($children) > 0) {
            $query->with('broker')->with('user')->whereIn('userId', $children);
        } else {
            $query->where('userId', $userId)->with('broker');
        }

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('transaction_at', [$start_date, $end_date]);
        }

        if (@$search['filter_broker'] && @$search['filter_broker'] != 'all') {
            $query->where('brokersId', $search['filter_broker']);
        }

        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);

        if($searchTerms){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function($query) use ($freetexts){
                    $query->where('email','like', '%' . $freetexts . '%');
                });
            }

        }

        return $query->orderby('transaction_at');
    }

    public static function get_record($search)
    {

        $query = Commissions::sortable()->with('pamm')->whereHas('user', function ($query) {
           return $query->where('role', 1);
        });

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function ($q) use ($freetexts) {
                    $q->where('email', 'like', '%' . $freetexts . '%')
                        ->orWhere('name', 'like', '%' . $freetexts . '%');
                });
            }
        }


        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('transaction_at', [$start_date, $end_date]);
        }

        if (@$search['type']) {
            $users = User::find(@$search['user_id']);
            $users_id = [];
            if ($users) {
                $users_id[] = $users->id;
                $users_id = array_merge($users->getChildrenIds(), $users_id);
                $query->whereIn('userId', $users_id);
            }


        }
        $search_country = @$search['country'] ?? NULL;

        if ($search_country) {
            $query->whereHas('user', function ($q) use($search_country) {
                $q->where('country', $search_country);
            });
        }

        $pamm_id = @$search['pamm_id'] ?? NULL;
        if ($pamm_id) {
            $query->whereHas('pamm', function ($q) use($pamm_id) {
                $q->where('id', $pamm_id);
            });
        }

        return $query->orderbyDesc('transaction_at');
    }

    public static function listProcessingStatus()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CALCULATED,
        ];
    }

    public static function getProcessingStatus($status)
    {
        switch( $status) {
            case self::STATUS_PENDING:
                return 'Processing';
            case self::STATUS_CALCULATED:
                return 'Calculated';

            default:
                return 'Invalid Status';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id')->where('role', 1);
    }

    public function broker()
    {
        return $this->belongsTo(Brokers::class, 'brokersId', 'id');
    }

    public function pamm()
    {
        return $this->belongsTo(Pamm::class, 'pamm_id', 'id');
    }
}
