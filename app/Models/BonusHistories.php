<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class BonusHistories extends Model
{
    use HasFactory, Sortable;

    protected $table = 'bonus_history';
    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    protected $dateFormat = 'Y-m-d H:i:s';

    public $sortable = [
        'commission_lot',
        'bonus_amount',
        'downline_id',
        'brokersId',
        'status',
        'from_commissions_id',
        'bonushistory_type',
        'created_at'
    ];

    public static function get_record($search)
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfDay();

        $query = BonusHistories::sortable()
            ->with('commission')
            ->with('user')
            ->whereNot('bonushistory_type', 'PB')
            ->where('deleted_at', '=', null)
            ->whereHas('user', function ($query) {
                return $query->where('role', 1);
            });

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if ($search_text) {
            foreach ($freetext as $freetexts) {
                $query->whereHas('commission', function ($q) use ($freetexts) {
                    $q->whereHas('user', function ($innerQ) use ($freetexts) {
                        $innerQ->where('email', 'like', '%' . $freetexts . '%')
                            ->orWhere('name', 'like', '%' . $freetexts . '%');
                    });
                });
            }
        }

        if (@$search['user_id']) {
            $users = User::find(@$search['user_id']);
            $users_id = $users->getChildrenIds();
            $query->where('upline_id', @$search['user_id'])->whereIn('downline_id', $users_id);
        }

        if (@$search['transaction_start']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay();
        } else {
            $start_date = $threeMonthsAgo; // Default to 3 months ago
        }


        if (@$search['transaction_end']) {
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay();
        } else {
            $end_date = Carbon::now()->endOfDay(); // Default to today
        }

        $query->whereBetween('created_at', [$start_date, $end_date]);

        if (@$search['bonushistory_type']) {
            $query->where('bonushistory_type', @$search['bonushistory_type']);
        }

        return $query->orderByDesc('created_at');
    }

    public static function get_summary_record($search)
    {
        $default_bonushistory_type = 'extra_bonus';

        $query = DB::table('bonus_history as b')
            ->select('b.upline_id', 'u.name', 'u.email', DB::raw('SUM(b.commission_lot) as total_commission_lot'), DB::raw('SUM(b.bonus_amount) as total_bonus_amount'), 'b.bonushistory_type', DB::raw('MAX(b.created_at) as created_at'))
            ->join('users as u', function ($join) {
                $join->on('b.upline_id', '=', 'u.id')
                    ->where('u.role', 1)
                    ->whereNull('u.deleted_at');
            })
            ->whereIn('b.bonushistory_type', ['network', 'extra_bonus'])
            ->groupBy('b.upline_id', 'u.name', 'u.email', 'b.bonushistory_type');

        $searchTerms = @$search['freetext'] ?? null;
        if ($searchTerms) {
            $freetext = explode(' ', $searchTerms);
            foreach ($freetext as $freetexts) {
                $query->where(function ($query) use ($freetexts) {
                    $query->where('u.email', 'like', '%' . $freetexts . '%')
                        ->orWhere('u.name', 'like', '%' . $freetexts . '%');
                });
            }
        }

        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('b.created_at', [$start_date, $end_date]);
        }

        if (@$search['bonushistory_type']) {
            $query->where('bonushistory_type', @$search['bonushistory_type']);
        } else {
            $query->where('bonushistory_type', $default_bonushistory_type);
        }

        return $query;
    }

    public static function get_commissions_table($search, $userId)
    {
        $query = BonusHistories::sortable()
            ->with('commission')
            ->with('user')
            ->whereNot('bonushistory_type', 'PB')
            ->where('deleted_at', '=', null)
            ->where('upline_id', $userId)
            ->where('downline_id', '!=', $userId);

        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);

        if($searchTerms){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function($query) use ($freetexts){
                    $query->where('email','like', '%' . $freetexts . '%')
                        ->orWhere('name','like', '%' . $freetexts . '%');
                });
            }

        }
        if (@$search['transaction_start'] && @$search['transaction_end']) {
            $start_date = Carbon::parse(@$search['transaction_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['transaction_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereHas('commission', function($q) use ($start_date, $end_date) {
                $q->whereBetween('transaction_at', [$start_date, $end_date]);
            });
        }

        return $query->orderbyDesc('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'downline_id', 'id')->where('role', 1);
    }
    public function commission()
    {
        return $this->belongsTo(Commissions::class, 'from_commissions_id', 'id');
    }

}
