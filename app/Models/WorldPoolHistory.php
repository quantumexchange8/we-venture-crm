<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;

class WorldPoolHistory extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $table = 'world_pool_history';

    protected $fillable = [
        'userId',
        'worldpoolId',
        'pool_type',
        'total_lot',
        'total_UM_RM',
        'net_lot',
        'pool_commission',
        'pool_amount',
        'from_time',
        'to_time',
        'status',
    ];

    protected $casts = [
        'from_time' => 'datetime',
        'to_time' => 'datetime',
    ];

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    public static function get_record($search, $userRole = 1)
    {
        $query = WorldPoolHistory::sortable();

        if ($userRole == 1) {
            $query->where('userId', Auth::id());
        } else {
            $query->whereHas('user', function ($query) {
                $query->where('role', 1);
            });
        }

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function ($q) use ($freetexts) {
                    $q->where('pool_type', 'like', '%' . $freetexts . '%');
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

        return $query->orderbyDesc('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
