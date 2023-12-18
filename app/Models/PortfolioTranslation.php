<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PortfolioTranslation extends Model
{
    use HasFactory, LogsActivity;

    protected $foreignKey = 'portfolio_id';

    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        $portfolio = $this->fresh();

        return LogOptions::defaults()
            ->useLogName('portfolio')
            ->logOnly(['name', 'description'])
            ->setDescriptionForEvent(function (string $eventName) use ($portfolio) {
                return Auth::user()->id . " has {$eventName} portfolio of {$portfolio->id}.";
            })
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
