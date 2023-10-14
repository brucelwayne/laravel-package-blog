<?php
namespace Brucelwayne\Blog\Models;

use Brucelwayne\Blog\Enums\BlogStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use Veelasky\LaravelHashId\Eloquent\HashableId;

/**
 * @property integer $team_id
 * @property integer creator_id
 * @property integer author_id
 * @property string featured_image_url
 * @property integer cate_id
 * @property BlogStatus status
 * @property string title
 * @property string slug
 * @property string excerpt
 * @property string content
 * @property string seo_title
 * @property string seo_keywords
 * @property string seo_content
 */
class BlogModel extends Model
{
    use HashableId;
//    use HasSlug;
//    use HasTranslations, HasTranslatableSlug;
//    public $translatable = ['title', 'slug'];

    protected $table = 'blogs';

    //region hash id
    protected $hashKey = self::class;
    protected $appends = [
        'hash'
    ];
    public function getRouteKeyName(): string
    {
        return 'hash';
    }
    //endregion

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'team_id',
        'creator_id',
        'author_id',
        'featured_image_url',
        'cate_id',
        'status',
        'title',
        'slug',
        'excerpt',
        'content',
        'seo_title',
        'seo_keywords',
        'seo_content',
        'token',
    ];

    protected $casts = [
        'status',
    ];

    //slug
//    public function getSlugOptions() : SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom('title')
//            ->saveSlugsTo('slug')
//            ->slugsShouldBeNoLongerThan(190)
//            ->doNotGenerateSlugsOnUpdate(); //for permalinks
//    }

    public static function byToken($token){
        return self::where('token',$token)->first();
    }

    public static function byTokenOrFail($token){
        return self::where('token',$token)->firstOrFail();
    }
}