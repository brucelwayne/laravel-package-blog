<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    function index($slug, Request $request){
        $blog_model = BlogModel::bySlugOrFail($slug);
        return view('blog::blog.single',[
            'blog'=>$blog_model,
        ]);
    }
}