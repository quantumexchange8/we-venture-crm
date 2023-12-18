<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class RankUpdateLogs extends Model
{
    use HasFactory, Sortable;

    protected $table = 'ranking_update_log';


    protected $guarded = ['id'];

    public $sortable = [
        'id',
        'user_id',
        'old_rank',
        'new_rank',
    ];

    public static function get_record($search)
    {

        $query = RankUpdateLogs::sortable()->whereHas('user', function ($query) {
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
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }


        return $query->orderbyDesc('created_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function old_rank()
    {
        return $this->belongsTo(Rankings::class, 'old_rank', 'id');
    }

    public function new_rank()
    {
        return $this->belongsTo(Rankings::class, 'new_rank', 'id');
    }
}
