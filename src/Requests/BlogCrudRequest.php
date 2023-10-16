<?php

namespace Brucelwayne\Blog\Requests;

use Brucelwayne\Blog\Enums\BlogCrudActions;
use Brucelwayne\Blog\Enums\BlogStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Mallria\Core\Enums\PostStatus;

class BlogCrudRequest extends FormRequest
{
    public function rules()
    {
        return array(
            'title' => ['sometimes','max:200'],
            'excerpt' => ['sometimes',],
            'content' => ['sometimes', ],
            'image' => ['sometimes', 'max:32'],//hash
//            'token' => ['required','max:21'],
            'crud' => ['required', new Enum(BlogCrudActions::class)],
            'hash' => ['sometimes', 'max:32'],
            'slug' => ['sometimes', 'max:190'],
            'status' => ['required', new Enum(PostStatus::class)],
        );
    }
}