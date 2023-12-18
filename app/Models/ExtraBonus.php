<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ExtraBonus extends Model
{
    use HasFactory, Sortable, SoftDeletes;

    protected $table = 'extra_bonus';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'bonus_amount', 'user_id', 'deleted_at'
    ];

    public $sortable = [
        'bonus_amount', 'user_id'
    ];

    public static function get_record($search)
    {
        $query = ExtraBonus::sortable()->where('deleted_at', null)->whereHas('user', function ($query) {
            return $query->where('status', User::STATUS_ACTIVE)->where('role', User::ROLE_MEMBER);
        });

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->whereHas('user', function ($q) use ($freetexts) {
                    $q->where('name', 'like', '%' . $freetexts . '%')
                        ->orWhere('email', 'like', '%' . $freetexts . '%');
                });
            }
        }

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        return $query->orderbyDesc('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
