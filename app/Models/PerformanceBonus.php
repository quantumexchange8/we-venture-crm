<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PerformanceBonus extends Model
{
    use HasFactory, Sortable;

    protected $table = 'performance_bonus';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'downline_id', 'downline_rank', 'upline_id', 'upline_rank', 'commission_amount', 'bonus_percentage', 'bonus_amount', 'is_claimed', 'from_commissions_id'
    ];

    public $sortable = [
        'downline_id', 'downline_rank', 'upline_id', 'upline_rank', 'commission_amount', 'bonus_percentage', 'bonus_amount', 'is_claimed',
    ];

    public static function get_report_record($search)
    {
        $query = PerformanceBonus::sortable()->whereHas('upline', function ($query) {
            return $query->where('role', 1);
        });

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->whereHas('upline', function ($q) use ($freetexts) {
                    $q->where('name', 'like', '%' . $freetexts . '%');
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

    public static function get_record($search, $user_id)
    {
        $query = PerformanceBonus::sortable()->where('upline_id', $user_id);

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->whereHas('upline', function ($q) use ($freetexts) {
                    $q->where('name', 'like', '%' . $freetexts . '%');
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

    public function downline()
    {
        return $this->belongsTo(User::class, 'downline_id', 'id');
    }

    public function upline()
    {
        return $this->belongsTo(User::class, 'upline_id', 'id');
    }

}
