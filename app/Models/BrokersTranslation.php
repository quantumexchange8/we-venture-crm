<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokersTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'description', 'note'];

    public function tbl_brokers()
    {
        return $this->belongsTo(Brokers::class, 'brokers_id', 'id');
    }}
