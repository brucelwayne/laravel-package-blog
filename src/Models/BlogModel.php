<?php

namespace Brucelwayne\Blog\Models;

use Brucelwayne\Blog\Enums\BlogStatus;
use Illuminate\Database\Eloquent\Model;
use Mallria\Core\Enums\PostType;
use Mallria\Core\Models\PostModel;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use Veelasky\LaravelHashId\Eloquent\HashableId;


/**
 * @property string url
 */
class BlogModel extends PostModel
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        parent::append(array_merge(parent::getAppends(),[
            'url',
        ]));
    }

    function getUrlAttribute(){
        return $this->singleUrl();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->type = PostType::Blog->value;
        });

        static::created(function ($instance) {
            //
        });
    }

    public static function bySlug($slug, $team_id = 0)
    {
        return self::where('slug', $slug)
            ->withTeam(0)
            ->withType(PostType::Blog)
            ->first();
    }

    public static function bySlugOrFail($slug, $team_id = 0)
    {
        return self::where('slug', $slug)
            ->withTeam(0)
            ->withType(PostType::Blog)
            ->firstOrFail();
    }

    public function singleUrl()
    {
        if (empty($this->slug)) {
            return route('blog.single.hash', ['hash' => $this->hash]);
        }else{
            return route('blog.single.slug', ['slug' => $this->slug]);
        }
    }
}