<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use SEOTools;

    function singleByHash($hash, string $slug = '')
    {
        $blog_model = BlogModel::byHashOrFail($hash);

        $seo_title = $blog_model->getSeoTitle($blog_model->title);
        $seo_description = $blog_model->getSeoDescription($blog_model->excerpt);
        $this->seo()->setTitle($seo_title);
        $this->seo()->setDescription($seo_description);
        $this->seo()->opengraph()->setUrl($blog_model->getUrl());
        $this->seo()->opengraph()->addProperty('type', 'article');
        $this->seo()->twitter()->setSite('@mallria');
        $this->seo()->jsonLdMulti()
            ->setType('Article')
            ->setUrl($blog_model->getUrl())->setTitle($seo_title)
            ->setDescription($seo_description);

        return view('blog::blog.single', [
            'blog' => $blog_model,
        ]);
    }

    function singleBySlug($hash, $slug, Request $request)
    {
//        $blog_model = BlogModel::bySlugOrFail($slug);
//        return view('blog::blog.single', [
//            'blog' => $blog_model,
//        ]);
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