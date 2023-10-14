<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Admin\Models\AdminModel;
use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Facades\BlogFacade;
use Brucelwayne\Blog\Models\BlogModel;
use Brucelwayne\Blog\Requests\CreateBlogRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    function single(Request $request)
    {
        $hash = $request->get('hash');

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
//        $blog_model = BlogModel::byToken($request->validated('token'));
//        if (!empty($blog_model)) {
//            return Inertia::renderVue('Blog/Admin/Create', [
//                'token' => NanoIdFacade::generate(),
//                'error' => 'Duplicated token for create blog post',
//            ]);
//        }

        $slug = BlogFacade::getSlug($request->validated('title'));

        $blog_slug_model = BlogModel::bySlug($slug);
        //如果slug不存在
        if (!empty($blog_slug_model)){
            $slug = $slug .'-'.NanoIdFacade::generate();
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
            'featured_image_url' => $request->validated('featured_image_url'),
            'slug' => $slug,
            'title' => $request->validated('title'),
            'excerpt' => $request->validated('excerpt'),
            'content' => $request->validated('content'),
            'token' => $request->validated('token'),
        ]);



        return to_route('admin.blog.edit.show',[
            'hash' => $blog_model->hash,
        ]);
    }

    function edit(Request $request)
    {
        $hash = $request->get('hash');
        $blog_model = BlogModel::byHash($hash);

        if (empty($blog_model)){
            return to_route('admin.blog.index');
        }

        return Inertia::renderVue('Blog/Admin/Edit',[
           'blog'=>$blog_model
        ]);
    }

    function update()
    {

    }
}