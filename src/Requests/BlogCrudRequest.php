<?php

namespace Brucelwayne\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogCrudRequest extends FormRequest
{
    public function rules()
    {
        return array(
            'title' => ['required', 'max:200'],
            'excerpt' => ['required'],
            'content' => ['required'],
            'featured_image_url' => ['required'],
//            'token' => ['required','max:21'],
            'action' => ['required', Rule::in('create', 'edit')],
            'hash' => ['sometimes', 'max:32'],
            'slug' => ['sometimes', 'required', 'max:190'],
        );
    }
}