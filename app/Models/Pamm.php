<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pamm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pamms';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'code', 'status', 'user_id', 'deleted_at'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function get_pamm_sel(): array
    {
        $query = Pamm::query();

        $query->where('deleted_at', '=', null);

        return $query->orderby('id')->get()->pluck('name', 'id')->toArray();
    }

}
