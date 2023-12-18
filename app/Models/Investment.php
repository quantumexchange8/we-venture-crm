<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Investment extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Sortable, LogsActivity;

    protected $guarded = [];

    public $sortable = [
        'deposit_amount',
        'status',
        'created_at',
    ];

    public static function get_records($search)
    {
        $query = Investment::sortable()->with('user');

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

        if (@$search['filter_status'] && @$search['filter_status'] != 'all') {
            $query->where('status', $search['filter_status']);
        }

        return $query->orderByDesc('created_at');
    }

    public static function get_member_records($search, $userId)
    {
        $query = Investment::sortable()->where('user_id', $userId);

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

    public static function status_listing()
    {
        return [
            'processing',
            'approved',
            'rejected'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        $investment = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('investment')
            ->logOnly(['portfolio_id', 'deposit_amount', 'status'])
            ->setDescriptionForEvent(function (string $eventName) use ($investment) {
                return Auth::user()->id . " has {$eventName} investment of {$investment->id}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function portfolio(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Portfolio::class, 'id','portfolio_id');
    }
}
