<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [];

    public static function getKeyValue()
    {
        $plucked = Settings::all()->pluck(
            'value',
            'name'
        );

        return $plucked->all();
    }
}
