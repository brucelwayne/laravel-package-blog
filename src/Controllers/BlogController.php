<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    function singleByHash(Request $request){
        $hash = $request->get('hash');
        $blog_model = BlogModel::byHashOrFail($hash);
        return view('blog::blog.single', [
            'blog' => $blog_model,
        ]);
    }

    function singleBySlug($slug, Request $request)
    {
        $blog_model = BlogModel::bySlugOrFail($slug);
        return view('blog::blog.single', [
            'blog' => $blog_model,
        ]);
    }

    function index()
    {
        $blog_models = BlogModel::where('team_id', 0)
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();
        return view('blog::blog.index', [
            'blogs' => $blog_models,
        ]);
    }
}