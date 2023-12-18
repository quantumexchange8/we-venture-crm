<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_wallets';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'wallet_type', 'wallet_address', 'wallet_address_request', 'wallet_address_request_status', 'wallet_status', 'requested_at', 'deleted_at'
    ];

    //Request Status
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    //Wallet Status
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function get_record($search, $perpage)
    {
        $query = UserWallet::with('user');

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
            $query->whereBetween('requested_at', [$start_date, $end_date]);
        }

        if (@$search['wallet_address_request_status']) {
            $query->where('wallet_address_request_status', $search['wallet_address_request_status']);
        }

        return $query->orderbyDesc('requested_at')->paginate($perpage);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
