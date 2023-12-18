<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorldPool extends Model
{
    use SoftDeletes;

    protected $table = 'world_pool';

    protected $casts = [
        'from_time' => 'datetime',
        'to_time' => 'datetime',
    ];
}
