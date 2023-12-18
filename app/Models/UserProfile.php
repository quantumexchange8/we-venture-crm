<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function get_record($search, $perpage)
    {
        $query = UserProfile::with('user');

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if ($search_text) {
            $query->where(function ($query) use ($freetext) {
                foreach ($freetext as $freetexts) {
                    $query->orWhereHas('user', function ($q) use ($freetexts) {
                        $q->where('email', 'like', '%' . $freetexts . '%')
                            ->orWhere('name', 'like', '%' . $freetexts . '%');
                    });
                }
            })->orWhere('name', 'like', '%' . $search_text . '%');
        }

        if (@$search['created_start'] && @$search['created_end']) {
            $start_date = Carbon::parse(@$search['created_start'])->startOfDay()->format('Y-m-d H:i:s');
            $end_date = Carbon::parse(@$search['created_end'])->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        if (@$search['status']) {
            $query->where('status', $search['status']);
        }

        return $query->orderbyDesc('created_at')->paginate($perpage);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
