<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Deposits extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $guarded = [];
    protected $casts = [
        'transaction_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public $sortable = [
        'brokersId',
        'amount',
        'transaction_at',
    ];

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAW = 2;

    public static function getActiveUserDepositAmount()
    {
        $amount = self::where('type', Deposits::TYPE_DEPOSIT)->with('user')->whereHas('user', function($q) {
            $q->where('status', User::STATUS_ACTIVE);
        })->sum('amount');

        return $amount;
    }

    public static function get_deposits_table($search, $perpage, $userId)
    {
        $query = Deposits::sortable()->where('userId', $userId)->with('broker');

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('transaction_at', [$start_date, $end_date]);
        }

        if (@$search['filter_broker'] && @$search['filter_broker'] != 'all') {
            $query->where('brokersId', $search['filter_broker']);
        }

        return $query->orderbyDesc('transaction_at')->paginate($perpage);
    }

    public static function get_record($search, $id, $perpage)
    {
        $query = Deposits::sortable()->where('deposits.userId', $id);

        if(@$search['brokersId']){
            $brokerId = @$search['brokersId'];
        }

        if(isset($brokerId)){
            $query->where('brokersId', $brokerId);
        }

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('transaction_at', [$start_date, $end_date]);
        }

        return $query->orderbyDesc('created_at')->paginate($perpage);
    }

    public static function get_report_record($search)
    {
        $query = Deposits::sortable()->with('pamm')->whereHas('user', function ($query) {
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

        if (@$search['type']) {
            $users = User::find(@$search['user_id']);
            $users_id = [];
            if ($users) {
                $users_id[] = $users->id;
                $users_id = array_merge($users->getChildrenIds(), $users_id);
                $query->whereIn('userId', $users_id);
            }


        }

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('transaction_at', [$start_date, $end_date]);
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

        return $query->orderbyDesc('created_at');
    }
    public static function get_member_daily_monthly_table($search, $user)
    {
        $members = array_merge($user->getChildrenIds(), [$user->id]);
        $query = Deposits::sortable()->with('broker')->with('user');
        $dep_type = Deposits::TYPE_DEPOSIT;
        $with_type = Deposits::TYPE_WITHDRAW;
        $status = Deposits::STATUS_APPROVED;

            if (@$search['user_id']) {
                $search_user = User::find(@$search['user_id']);
                if ($search_user) {
                    $members = array_merge($search_user->getChildrenIds(),  [$search_user->id]);
                }
            }
            $query->whereIn('userId', $members);

            $start_date = $end_date = null;
            if (@$search['filter_type'] == 'monthly') {
                if (@$search['filter_month'] && @$search['filter_year']) {
                    $start_date = Carbon::createFromDate(@$search['filter_year'], @$search['filter_month'])->startOfMonth()->format('Y-m-d H:i:s');
                    $end_date = Carbon::createFromDate(@$search['filter_year'], @$search['filter_month'])->endOfMonth()->format('Y-m-d H:i:s');
                }
            } else {
                if (@$search['transaction_start'] && @$search['transaction_end']) {
                    $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
                    $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
                }
            }
            if ($start_date && $end_date) {
                $query->whereBetween('transaction_at', [$start_date, $end_date]);
            }

            if (@$search['filter_type'] == 'monthly') {
                return $query->select('brokersId', 'userId',
                    DB::raw("sum(CASE WHEN type = $dep_type THEN amount END) as dep_amount"),
                    DB::raw("sum(CASE WHEN type = $with_type AND status = $status THEN amount END) as with_total"),
                    DB::raw("(DATE_FORMAT(transaction_at, '%m-%Y')) as month_year"),
                )->groupBy('brokersId', 'userId', 'month_year')->orderbyDesc('month_year');
            } else {
                return $query->select('brokersId', 'userId',
                    DB::raw("sum(CASE WHEN type = $dep_type THEN amount END) as dep_amount"),
                    DB::raw("sum(CASE WHEN type = $with_type AND status = $status THEN amount END) as with_total"),
                    DB::raw('DATE(transaction_at) as date'),
                )->groupBy('brokersId', 'userId', 'date')->orderbyDesc('date');
            }
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
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
