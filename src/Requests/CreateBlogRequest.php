<?php
namespace Brucelwayne\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    public function rules(){
        return array(
            'title' => ['required','max:200'],
            'excerpt' => ['required'],
            'content'=>['required'],
            'featured_image_url' => ['required'],
//            'token' => ['required','max:21'],
        );
    }
}