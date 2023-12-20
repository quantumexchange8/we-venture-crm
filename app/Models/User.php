<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, Sortable, LogsActivity;


    //kyc approval status
    const KYC_STATUS_NOT_VERIFY = 1;
    const KYC_STATUS_PENDING_VERIFICATION = 2;
    const KYC_STATUS_VERIFIED = 3;
    const KYC_STATUS_REJECTED = 4;

    //use status section
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    //user role section
    const ROLE_MEMBER = 1;
    const ROLE_ADMIN = 2;

    //withdrawal action
    const ENABLE_WITHDRAWAL = 1;
    const DISABLE_WITHDRAWAL = 0;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $sortable = [
        'name',
        'email',
        'contact_number',
        'country',
        'status',
        'created_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance' => 'decimal:2',
        'auto_rank_up' => 'boolean',
    ];

    public function setReferralId()
    {
        $temp_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz"), 0, 10 - strlen((string)$this->id));
        $this->referral_id = $temp_code. $this->id;
        $this->save();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public static function getActiveUsersCount()
    {
        $count = self::where('status', self::STATUS_ACTIVE)->where('role', self::ROLE_MEMBER)->count();

        return $count;
    }

    /**
     *   Return list of status codes and labels
     * @return array
     */
    public static function listUserStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    /**
     *   Return list of status codes and labels
     * @return array
     */
    public static function listRole()
    {
        return [
            self::ROLE_MEMBER    => 'member',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public static function get_record($search, $kyc = false, $member_id = null)
    {
        $query = User::sortable()->where('role', 1);
        if ($member_id) {
            $query->where('hierarchyList', 'like', '%-' . $member_id . '-%');
        }
        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            $query2 = clone $query;
            foreach($freetext as $freetexts) {
                $query2->where(function ($q) use ($freetexts) {
                    $q->where('email', 'like', '%' . $freetexts . '%')
                        ->orWhere('name', 'like', '%' . $freetexts . '%');
                });
            }
            if (@$search['status'] && @$search['status'] =='leaders') {
                $query2->where('leader_status', true);

                $leaders = $query2->pluck('id')->toArray();

                $query->where(function ($q) use ($leaders) {
                    foreach($leaders as $leader) {
                        $q->where('hierarchyList', 'like', '%-' . $leader . '-%');
                    }
                });
            } else {
                $query = $query2;
            }
        }
        if ($kyc) {
            $query->where('kyc_approval_status', User::KYC_STATUS_PENDING_VERIFICATION);
        }

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $auto_rank_up = @$search['auto_rank_up'];

        if(isset($auto_rank_up)){
            $query->where('auto_rank_up', $auto_rank_up);
        }

        return $query->orderbyDesc('created_at');
    }

    public static function get_deleted_record($search, $kyc = false, $member_id = null)
    {
        $query = User::sortable()->onlyTrashed()->where('role', 1);
        if ($member_id) {
            $query->where('hierarchyList', 'like', '%-' . $member_id . '-%');
        }
        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            $query2 = clone $query;
            foreach($freetext as $freetexts) {
                $query2->where(function ($q) use ($freetexts) {
                    $q->where('email', 'like', '%' . $freetexts . '%')
                        ->orWhere('name', 'like', '%' . $freetexts . '%');
                });
            }
            if (@$search['status'] && @$search['status'] =='leaders') {
                $query2->where('leader_status', true);

                $leaders = $query2->pluck('id')->toArray();

                $query->where(function ($q) use ($leaders) {
                    foreach($leaders as $leader) {
                        $q->where('hierarchyList', 'like', '%-' . $leader . '-%');
                    }
                });
            } else {
                $query = $query2;
            }
        }
        if ($kyc) {
            $query->where('kyc_approval_status', User::KYC_STATUS_PENDING_VERIFICATION);
        }

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('deleted_at', [$start_date, $end_date]);
        }

        $auto_rank_up = @$search['auto_rank_up'];

        if(isset($auto_rank_up)){
            $query->where('auto_rank_up', $auto_rank_up);
        }

        return $query->orderbyDesc('deleted_at');
    }

    public static function get_member_tree_record($search)
    {
        $user = Auth::user();

        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);
        $members = [];
        if ($searchTerms) {
            $query =  User::query();
            foreach ($freetext as $freetexts) {
                $query->where('email', 'like', '%' . $freetexts . '%')
                    ->orWhere('name', 'like', '%' . $freetexts . '%');

            }
            $compare_users = array_intersect($query->pluck('id')->toArray(), $user->getChildrenIds());

            $members = User::whereIn('id', $compare_users)->take(1)->get();
        } else {
            $members = collect([(object) $user]);
        }

        return $members;
    }

    public static function get_admin_tree_record($search)
    {
        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);
        $members = [];
        if ($searchTerms) {
            foreach ($freetext as $freetexts) {
                $members = User::where('role', User::ROLE_MEMBER)
                    ->where('email', 'like', '%' . $freetexts . '%')
                    ->orWhere('name', 'like', '%' . $freetexts . '%')
                    ->take(1)
                    ->get();
            }

        } else {
            $members = User::where('role', User::ROLE_MEMBER)->whereNull('upline_referral_id')->get();
        }

        return $members;
    }

    public function getClientsCount()
    {
        $clients = $this->children()->count();

        return $clients;
    }

    public function getDownlinesCount()
    {
        $downlines = count($this->getChildrenIds());

        return $downlines;
    }
    public function getLeaders()
    {
        $top_leader = $first_leader = $default = 'OFFICIAL@WEVENTURE.CO';

        $upline = explode("-",substr($this->hierarchyList, 1, -1));
            $count = count($upline)-1;
        if ($count > 0) {
            while ($count > -1) {
                $user = User::find($upline[$count]);
                if (!empty($user->leader_status) && $user->leader_status == 1) {
                    if ($first_leader == $default) {
                        $first_leader = $user->name;
                    }
                    $top_leader = $user->email;
                }
                $count--;
            }
        }
        return [
            'top_leader' => $top_leader,
            'first_leader' => $first_leader];
    }
    public function getChildrenIds()
    {
        $users = User::query()->where('hierarchyList', 'like', '%-' . $this->id . '-%')
            ->where('status', self::STATUS_ACTIVE)
            ->pluck('id')->toArray();

        return $users;
    }

    public function getTranslatedCountry()
    {
        $country = SettingCountry::where('name', $this->country)->first();
        switch (app()->getLocale()) {

            case 'cn':
                $country = $country->name_cn;

                break;

            case 'tw':
                $country = $country->name_tw;

                break;

            default:
                $country = $country->name;
        }

        return $country;
    }

    public function groupTotalDeposit()
    {
        $users =$this->getChildrenIds();

        $group_deposit = Deposits::whereIn('userId', $users)->where('type', Deposits::TYPE_DEPOSIT)->sum('amount');
        $group_deposit_with= Deposits::whereIn('userId', $users)->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');
        return $group_deposit - $group_deposit_with;
    }
    public function groupDepositsByBrokers()
    {
        $users = User::query()->where('hierarchyList', 'like', '%-' . $this->id . '-%')->get();
        for ($i = 0; $i < count($users); $i++) {
            $users[$i]->total = $users[$i]->personalDeposits();
            $users[$i]->deposits = $users[$i]->personalDepositsByBrokers()->toArray();
        }
        return $users->sortBy('total', SORT_REGULAR, true);
    }
    public function personalDepositsByBrokers()
    {
        $dep_type = Deposits::TYPE_DEPOSIT;
        $with_type = Deposits::TYPE_WITHDRAW;
        $status = Deposits::STATUS_APPROVED;
        $brokers = $this->deposits()->with('broker')
            ->select('brokersId',
                DB::raw("sum(CASE WHEN type = $dep_type THEN amount END) as dep_amount"),
                DB::raw("sum(CASE WHEN type = $with_type AND status = $status THEN amount END) as with_total"),
            )
            ->groupBy('brokersId')->get();
        foreach($brokers as $broker) {
            $broker->amount = $broker->dep_amount - $broker->with_total;
        }
        return $brokers->sortBy('amount', SORT_REGULAR, true);
    }

    public function withdrawalAmountValidationByBrokers($id, $pamm_id)
    {
        $dep_type = Deposits::TYPE_DEPOSIT;
        $with_type = Deposits::TYPE_WITHDRAW;
        $status = Deposits::STATUS_APPROVED;
        $brokers = $this->deposits()
            ->select('brokersId',
                DB::raw("sum(CASE WHEN type = $dep_type THEN amount END) as dep_amount"),
                DB::raw("sum(CASE WHEN type = $with_type AND status = $status THEN amount END) as with_total"),
            )
            ->where(function ($query) use ($pamm_id) {
                $query->where('pamm_id', $pamm_id)
                    ->orWhere('pamm_id', 0);
            })
            ->where('brokersId', $id)
            ->groupBy('brokersId')->get();
        foreach($brokers as $broker) {
            $broker->amount = $broker->dep_amount - $broker->with_total;
        }
        return $brokers->sortBy('amount', SORT_REGULAR, true);
    }

    public function personalDeposits()
    {
        $personal_deposit = $this->deposits()
            ->where('type', Deposits::TYPE_DEPOSIT)->sum('amount');
        $personal_withdrawed_deposit = $this->deposits()
            ->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');

        return $personal_deposit - $personal_withdrawed_deposit;
    }


    public function personalCommissions()
    {
        return $this->commissions()->sum('commissions_amount');
    }

    public function groupTotalCommissions()
    {
        $users = $this->getChildrenIds();
        $underlineTotal = Commissions::whereIn('userId', $users)->sum('commissions_amount');
        $result = $underlineTotal + $this->personalCommissions();
        return $result;
    }

    public function userDailyMonthlyDeposit($month = false, $select_month = null, $select_year = null)
    {
        if ($select_month && $select_year) {
            $start_date = Carbon::createFromDate($select_year, $select_month, 1);
        } else {
            $start_date = Carbon::now();
        }

        if ($month) {
            $start_date = $start_date->startOfMonth();
            $end_date = $start_date->copy()->endOfMonth();

        } else {
            $start_date = $end_date = $start_date;
        }

        $start_date = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');

        $personal_deposit = $this->deposits()
            ->whereBetween('transaction_at', [$start_date, $end_date])
            ->where('type', Deposits::TYPE_DEPOSIT)
            ->sum('amount');
        $personal_withdrawed_deposit = $this->deposits()
            ->whereBetween('transaction_at', [$start_date, $end_date])
            ->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');

        return $personal_deposit - $personal_withdrawed_deposit;
    }

    public function groupDailyMonthlyDeposit($month = false)
    {

        $start_date = $end_date = Carbon::now();
        if ($month) {
            $start_date = $start_date->startOfMonth();
            $end_date = $start_date->copy()->endOfMonth();
        } else {
            $start_date = $end_date = $start_date;
        }

        $start_date = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');

        $users =$this->getChildrenIds();

        $personal_deposit = Deposits::whereIn('userId', $users)
            ->whereBetween('transaction_at', [$start_date, $end_date])
            ->where('type', Deposits::TYPE_DEPOSIT)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');
        $personal_withdrawed_deposit = Deposits::whereIn('userId', $users)
            ->whereBetween('transaction_at', [$start_date, $end_date])
            ->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');

        $underlineTotal = $personal_deposit - $personal_withdrawed_deposit;

        return $underlineTotal + $this->userDailyMonthlyDeposit($month);
    }

    public function userDailyMonthlyWithdrawal($month = false)
    {
        $start_date = $end_date = Carbon::now();
        if ($month) {
            $start_date = $start_date->startOfMonth();
            $end_date = $start_date->copy()->endOfMonth();

        } else {
            $start_date = $end_date = $start_date;
        }

        $start_date = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');

        $personal_withdrawal_query = $this->withdrawals()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->where('status', Withdrawals::STATUS_APPROVED);

        $amount = $fee = clone $personal_withdrawal_query;

        return $amount->sum('amount') + $fee->sum('transaction_fee');
    }

    public function groupDailyMonthlyWithdrawal($month = false)
    {

        $start_date = $end_date = Carbon::now();
        if ($month) {
            $start_date = $start_date->startOfMonth();
            $end_date = $start_date->copy()->endOfMonth();
        } else {
            $start_date = $end_date = $start_date;
        }

        $start_date = Carbon::parse($start_date)->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::parse($end_date)->endOfDay()->format('Y-m-d H:i:s');

        $users = $this->getChildrenIds();

        $personal_withdrawed_deposit = Deposits::whereIn('userId', $users)
            ->whereBetween('transaction_at', [$start_date, $end_date])
            ->where('type', Deposits::TYPE_WITHDRAW)
            ->where('status', Deposits::STATUS_APPROVED)
            ->sum('amount');

//        $amount = $fee = clone $personal_withdrawal_query;
//
//        $underlineTotal = $amount->sum('amount') + $fee->sum('transaction_fee');

        return $personal_withdrawed_deposit;
    }


    public function getRole()
    {
        $temp_role = self::listRole();
        return $temp_role[$this->role];
    }

    public static function getUserStatus($status)
    {
        switch( $status) {
            case self::STATUS_ACTIVE:
                return 'Active';
            case self::STATUS_INACTIVE:
                return 'Inactive';

            default:
                return 'Invalid Status';
        }
    }

    public static function getUserKYCStatus($status)
    {
        switch( $status) {
            case self::KYC_STATUS_PENDING_VERIFICATION:
                return 'Pending Verification';
            case self::KYC_STATUS_NOT_VERIFY:
                return 'Not Verify';
            case self::KYC_STATUS_REJECTED:
                return 'Rejected';
            case self::KYC_STATUS_VERIFIED:
                return 'Verified';

            default:
                return 'Invalid Status';
        }
    }



    public function rank()
    {
        return $this->hasOne(Rankings::class, 'id', 'rankId');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposits::class, 'userId', 'id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commissions::class, 'userId', 'id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawals::class, 'requested_by_user', 'id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'upline_referral_id');
    }
    public function parent()
    {
        return $this->belongsTo(User::class, 'upline_referral_id');
    }

    public function extra_bonus()
    {
        return $this->hasOne(ExtraBonus::class, 'user_id', 'id');
    }

    public function user_wallet()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'id');
    }

    public function upline_bonus()
    {
        return $this->hasMany(BonusHistories::class, 'upline_id', 'id');
    }

    public function user_profiles(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id')->where('status', '=', 'pending');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $user = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('user')
            ->logOnly([
                'name',
                'email',
                'role',
                'address',
                'rankId',
                'contact_number',
                'status',
                'is_deleted',
                'country',
                'wallet_balance',
                'kyc_approval_status',
                'withdrawal_action',
                'email_status',
            ])
            ->setDescriptionForEvent(function (string $eventName) use ($user) {
                $actorName = Auth::user() ? Auth::user()->name : 'New User';
                return "{$actorName} has {$eventName} {$user->name}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
