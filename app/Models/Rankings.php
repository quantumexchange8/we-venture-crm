<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Rankings extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $guarded = [];
    protected $casts = [
        'package_requirement' => 'decimal:2',
        'group_sales' => 'decimal:2',
    ];

    public $sortable = ['name'];

    public static function get_rank_sel(): array
    {
        $query = Rankings::where('deleted_at', null);

        return $query->orderby('position')->get()->pluck('name', 'id')->toArray();
    }

}
