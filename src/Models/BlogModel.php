<?php

namespace Brucelwayne\Blog\Models;

use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Enums\BlogType;
use Mallria\Core\Enums\PostType;
use Mallria\Core\Models\BaseMysqlModel;
use Mallria\Media\Models\MediaModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Veelasky\LaravelHashId\Eloquent\HashableId;


/**
 *
 *
 * @property integer $team_id
 * @property integer creator_id
 * @property integer author_id
 * @property BlogType type
 *
 * @property integer image_id The cover of this blog
 * @property integer gallery_ids
 * @property integer video_id
 *
 * @property integer cate_id
 * @property BlogStatus status
 * @property string title
 * @property string slug
 * @property string excerpt
 * @property string content
 * @property string seo_title
 * @property string seo_keywords
 * @property string seo_content
 *
 * @method static static create(...$args)
 * @method static static first()
 * @method static static firstOrFail()
 * @method static static where(...$args)
 * @method static static orderBy(...$args)
 * @method static static paginate($limit)
 * @method static static withQueryString()
 *
 * @method static static withType(PostType $type)
 * @method static static withTeam($team_id)
 *
 *  //relations
 * @property MediaModel image
 *
 * //attributes
 * @property string url
 */
class BlogModel extends BaseMysqlModel implements HasMedia
{
    use HashableId;
    use InteractsWithMedia;
    use HasTranslations;

    protected $table = 'blogs';

    public $translatable = ['title', 'excerpt', 'content', 'seo_title', 'seo_keywords', 'seo_description'];

    //region hash id
    protected $hashKey = self::class;
    protected $appends = [
        'hash'
    ];

    public function getRouteKeyName(): string
    {
        return 'hash';
    }

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'team_id',
        'creator_id',
        'author_id',
        'type',
        'cate_id',
        'status',
        'title',
        'slug',
        'excerpt',
        'content',
        'seo_title',
        'seo_keywords',
        'seo_content',
        'image_id',
        'gallery_ids',
        'video_id',
    ];

    protected $casts = [
        'type' => BlogType::class,
        'status' => BlogStatus::class,
    ];

    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function scopeWithType($query, BlogType $type)
    {
        return $query->where('type', $type->value);
    }

    public function scopeWithTeam($query, $team_id = 0)
    {
        return $query->where('team_id', $team_id);
    }

    public static function createDraft($creator_id, $team_id = 0): static
    {
        return static::create([
            'team_id' => $team_id,
            'creator_id' => $creator_id,
            'status' => BlogStatus::Draft->value,
        ]);
    }

    public function image()
    {
        return $this->hasOne(MediaModel::class, 'id', 'image_id');
    }

    //region attributes
    function getUrlAttribute()
    {
        return $this->getUrl();
    }

    //endregion


    public static function bySlug($slug, $team_id = 0)
    {
        return static::where('slug', $slug)
            ->withTeam(0)
            ->first();
    }

    public static function bySlugOrFail($slug, $team_id = 0)
    {
        return static::where('slug', $slug)
            ->withTeam(0)
            ->firstOrFail();
    }

    public static function byId($id)
    {
        return static::where('id', $id)
            ->first();
    }

    public function getUrl()
    {
        if (empty($this->slug)) {
            return route('blog.single.hash', ['hash' => $this->hash]);
        } else {
            return route('blog.single.slug', ['slug' => $this->slug]);
        }
    }
}