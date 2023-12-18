<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Portfolio extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Translatable, LogsActivity;

    protected $guarded = [];
    public $translatedAttributes = ['name', 'description'];

    public static function get_record($search, $perpage)
    {
        $query = Portfolio::translatedIn(app()->getLocale());

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where(function ($q) use ($freetexts) {
                    $q->where('name', 'like', '%' . $freetexts . '%');
                });
            }
        }

        return $query->orderby('created_at')->paginate($perpage);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $portfolio = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('portfolio')
            ->logOnly(['min_amount', 'status'])
            ->setDescriptionForEvent(function (string $eventName) use ($portfolio) {
                return Auth::user()->id . " has {$eventName} portfolio of {$portfolio->id}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
