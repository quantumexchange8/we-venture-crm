<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Announcements extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'announcements';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'content', 'selected_users', 'user_ids', 'visibility', 'popup_status', 'userId', 'deleted_at'
    ];

    protected $casts = [
        'visibility' => 'boolean',
    ];

    public static function get_record($search, $perpage)
    {
        $query = Announcements::where('deleted_at', null);

        $search_text = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $search_text);

        if($search_text){
            foreach($freetext as $freetexts) {
                $query->where(function ($q) use ($freetexts) {
                    $q->where('title', 'like', '%' . $freetexts . '%');
                });
            }
        }

        return $query->orderby('created_at', 'desc')->paginate($perpage);
    }
}
