<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brokers extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Translatable;

    protected $guarded = [];
    protected $casts = [];

    public $sortable = ['name'];
    public $translatedAttributes = ['name', 'description', 'note'];

    public static function get_record($search, $perpage)
    {
        $query = Brokers::translatedIn(app()->getLocale())->where('deleted_at', null);

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

    public static function get_broker_sel(): array
    {
        $query = Brokers::query();

        $query->where('deleted_at', '=', null);

        return $query->orderby('name')->get()->pluck('name', 'id')->toArray();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposits::class, 'brokersId', 'id');
    }
}
