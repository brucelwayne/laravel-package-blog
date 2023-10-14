<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Admin\Models\AdminModel;
use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Facades\BlogFacade;
use Brucelwayne\Blog\Models\BlogModel;
use Brucelwayne\Blog\Requests\CreateBlogRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mallria\Core\Facades\Inertia;
use Mallria\Core\Facades\NanoIdFacade;
use Mallria\Core\Http\Responses\ErrorJsonResponse;
use Mallria\Core\Http\Responses\SuccessJsonResponse;

class AdminController extends Controller
{
    function index()
    {

        return Inertia::renderVue('Blog/Admin/Index');
//        return view('blog::blog.admin.index');
    }

    function create()
    {
        return Inertia::renderVue('Blog/Admin/Create', [
            'token' => NanoIdFacade::generate(),
        ]);
//        return view('blog::blog.admin.create');
    }

    function store(CreateBlogRequest $request)
    {
        $blog_model = BlogModel::byToken($request->validated('token'));
        if (!empty($blog_model)){
            return new ErrorJsonResponse('Duplicated token for create blog post');
        }
        /**
         * @var AdminModel $admin
         */
        $admin = Auth::guard('admin')->user();
        $blog_model = BlogModel::create([
            'team_id' => 0,//system blog is 0
            'creator_id' => $admin->getKey(),
            'author_id' => $admin->getKey(),
            'cate_id' => 0, // no category
            'status' => BlogStatus::DRAFT->value,
            'featured_image_url' =>$request->validated('featured_image_url'),
            'slug' => BlogFacade::getSlug($request->validated('title')),
            'title' =>$request->validated('title'),
            'excerpt' =>$request->validated('excerpt'),
            'content' =>$request->validated('content'),
            'token' =>$request->validated('token'),
        ]);

        return new SuccessJsonResponse([
            'blog' => $blog_model
        ]);
    }

    function edit()
    {

    }

    function save()
    {

    }
}