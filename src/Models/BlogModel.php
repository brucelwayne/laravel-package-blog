<?php

namespace Brucelwayne\Blog\Models;

use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Enums\BlogType;
use Brucelwayne\SEO\Traits\HasSeo;
use Mallria\Core\Enums\PostType;
use Mallria\Core\Models\BaseMysqlModel;
use Mallria\Media\Models\MediaModel;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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
 * @property array gallery_ids
 * @property integer video_id
 *
 * @property integer cate_id
 * @property BlogStatus status
 * @property string title
 * @property string slug
 * @property string locale
 * @property string excerpt
 * @property string content
 * // * @property string seo_title
 * // * @property string seo_keywords
 * // * @property string seo_description
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
 * @method static save($data)
 *
 *  //relations
 * @property MediaModel $image
 * @property MediaModel $video
 * @property array<MediaModel> $gallery
 *
 * //attributes
 * @property string url
 */
class BlogModel extends BaseMysqlModel implements HasMedia
{
    use HashableId;
    use InteractsWithMedia;
    use HasTranslations;
    use HasSeo;

    public $translatable = ['slug', 'title', 'excerpt', 'content',
//        'seo_title', 'seo_keywords', 'seo_description'
    ];
    protected $table = 'blw_blogs';

    //region hash id
    protected $hashKey = 'blw_blogs';
    protected $appends = [
        'hash',
        'url',
        'gallery',
        'gallery_hash_ids',
        'seo',
    ];
    protected $hidden = [
        'id',
    ];
    protected $fillable = [
        'team_id',
        'creator_id',
        'author_id',
        'cate_id',

        'type',
        'status',
        'slug',
        'locale',

        'title',
        'excerpt',
        'content',

//        'seo_title',
//        'seo_keywords',
//        'seo_content',

        'image_id',
        'gallery_ids',
        'video_id',
    ];
    protected $casts = [
        'type' => BlogType::class,
        'status' => BlogStatus::class,
        'gallery_ids' => 'array',
    ];
    protected $with = [
        'image',
        'video',
    ];

    public static function createDraft($creator_id, $team_id = 0): static
    {
        return static::create([
            'team_id' => $team_id,
            'creator_id' => $creator_id,
            'status' => BlogStatus::Draft->value,
        ]);
    }

    //region attributes

    public static function byId($id)
    {
        return static::where('id', $id)
            ->first();
    }

    public function getRouteKeyName(): string
    {
        return 'hash';
    }

    function getUrlAttribute()
    {
        return $this->getUrl();
    }

    //endregion

    public function getUrl($localCode = null)
    {
        if (empty($localCode)) {
            $localCode = LaravelLocalization::getCurrentLocale();
        }
        $slug = $this->getTranslation('slug', $localCode);
        return route('blog.single', ['hash' => $this->hash, 'slug' => $slug]);
    }

    function getGalleryAttribute()
    {
        return $this->getGallery();
    }

    public function getGallery()
    {
//        return $this->hasMany(MediaModel::class, 'id', 'gallery_ids');

        if (empty($this->gallery_ids)) {
            return null;
        }
        $gallery_models = MediaModel::whereIn('id', $this->gallery_ids)->orderBy('id', 'asc')->get();
        $gallery = [];
        foreach ($this->gallery_ids as $gallery_id) {
            $gallery[] = collect($gallery_models)->first(function ($gallery_model) use ($gallery_id) {
                return $gallery_model->getKey() === $gallery_id;
            });
        }
        return $gallery;
    }

    function getGalleryHashIdsAttribute()
    {
        $gallery = $this->getGallery();
        if (!empty($gallery)) {
            return collect($gallery)->map(function ($g) {
                return $g->hash;
            });
        }
        return [];
    }

    public function registerMediaConversions($media = null): void
    {
        generate_thumbnail($this, $media);
//        $this->addMediaConversion('thumb')
//            ->width(368)
//            ->height(232)
//            ->sharpen(10);
    }

    public function scopeWithType($query, BlogType $type)
    {
        return $query->where('type', $type->value);
    }

    public function scopeWithTeam($query, $team_id = 0)
    {
        return $query->where('team_id', $team_id);
    }


//    public static function bySlug($slug, $team_id = 0)
//    {
//        return static::where('slug', $slug)
//            ->withTeam(0)
//            ->first();
//    }
//
//    public static function bySlugOrFail($slug, $team_id = 0)
//    {
//        return static::where('slug', $slug)
//            ->withTeam(0)
//            ->firstOrFail();
//    }

    public function image()
    {
        return $this->hasOne(MediaModel::class, 'id', 'image_id');
    }

    public function video()
    {
        return $this->hasOne(MediaModel::class, 'id', 'video_id');
    }
}