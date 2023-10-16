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


class BlogModel extends PostModel
{
    public static function boot(){
        parent::boot();

        static::creating(function ($instance){
            $instance->type = PostType::Blog->value;
        });

        static::created(function ($instance){
            //
        });
    }
}