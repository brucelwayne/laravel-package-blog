<?php

namespace Brucelwayne\Blog\Requests;

use Brucelwayne\Blog\Enums\BlogCrudActions;
use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Enums\BlogType;
use Brucelwayne\Blog\Rules\LocaleRule;
use Carbon\Traits\Localization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Mallria\Core\Enums\PostStatus;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class BlogCrudRequest extends FormRequest
{
    public function rules()
    {
        return array(

            'crud' => ['required', new Enum(BlogCrudActions::class)],

            'status' => ['required', new Enum(PostStatus::class)],

            'type' => ['sometimes', new Enum(BlogType::class)],

            'locale' => ['sometimes', 'required', new LocaleRule()],

            'hash' => ['sometimes', 'max:32'],
            'title' => ['required', 'max:190'],
            'slug' => ['sometimes', 'max:190'],
            'excerpt' => ['sometimes',],
            'content' => ['sometimes',],

            'seo_title' => ['sometimes',],
            'seo_keywords' => ['sometimes',],
            'seo_description' => ['sometimes',],


            'image_id' => ['sometimes', 'max:32'],//hash
            'gallery_ids' => ['sometimes', 'array', 'max:12'],//hash
            'video_id' => ['sometimes', 'max:32'],//hash
        );
    }
}
