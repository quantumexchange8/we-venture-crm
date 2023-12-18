<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Withdrawals extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $guarded = [];
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_fee' => 'decimal:2',
    ];

    public $sortable = [
        'network',
        'amount',
        'status',
        'created_at',
        'address'
    ];

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;
    const STATUS_CANCELLED = 4;


    const TRC20 = 'trc20';
    const ERC20 = 'erc20';
    const BEP20 = 'bep20';

    public static $walletTypes = [
        self::TRC20,
//        self::ERC20,
//        self::BEP20
    ];

    public static function getApprovedWithdrawalAmount()
    {
        $amount = self::where('status', self::STATUS_APPROVED)->sum('amount');

        return $amount;
    }

    public static function get_withdrawals_table($search, $userId)
    {
        $query = Withdrawals::sortable()->where('requested_by_user', $userId);

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if (@$search['filter_status'] && @$search['filter_status'] != 'all') {
            $query->where('status', $search['filter_status']);
        }

        return $query->orderByDesc('created_at');
    }

    public static function get_record($search)
    {
        $query = Withdrawals::sortable()->whereHas('user', function ($query) {
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

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if (@$search['status']) {
            $query->where('status', $search['status']);
        }

        if (@$search['type']) {
            $users = User::find(@$search['user_id']);
            $users_id = [];
            if ($users) {
                $users_id[] = $users->id;
                $users_id = array_merge($users->getChildrenIds(), $users_id);
                $query->whereIn('requested_by_user', $users_id);
            }

        }

        $search_country = @$search['country'] ?? NULL;
        if ($search_country) {
            $query->whereHas('user', function ($q) use($search_country) {
                $q->where('country', $search_country);
            });
        }

        return $query->orderbyDesc('created_at');
    }

    /**
     *   Return list of status codes and labels
     * @return array
     */
    public static function listApprovalStatus()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_APPROVED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELLED
        ];
    }

    public static function getApprovalStatus($status)
    {
        switch( $status) {
            case self::STATUS_PENDING:
                return 'process';
            case self::STATUS_APPROVED:
                return 'approved';
            case self::STATUS_REJECTED:
                return 'rejected';
            case self::STATUS_CANCELLED:
                return 'cancelled';

            default:
                return 'Invalid Status';
        }
    }

    public function getNetwork()
    {
        switch( $this->network) {
            case self::TRC20:
                return 'USDT(TRC20)';
            case self::ERC20:
                return 'USDT(ERC20)';
            case self::BEP20:
                return 'USDT(BEP20)';
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by_user', 'id');
    }
}
