<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Admin\Models\AdminModel;
use Brucelwayne\Blog\Enums\BlogCrudActions;
use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Facades\BlogFacade;
use Brucelwayne\Blog\Models\BlogModel;
use Brucelwayne\Blog\Requests\BlogCrudRequest;
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

    function store(BlogCrudRequest $request)
    {
//        $blog_model = BlogModel::byToken($request->validated('token'));
//        if (!empty($blog_model)) {
//            return Inertia::renderVue('Blog/Admin/Create', [
//                'token' => NanoIdFacade::generate(),
//                'error' => 'Duplicated token for create blog post',
//            ]);
//        }

        $action = BlogCrudActions::from($request->validated('action'));
        if ($action !== BlogCrudActions::Create) {
            return Inertia::renderVue('Blog/Admin/Create', [
                'error' => 'Invalid action',
            ]);
        }

        $slug = BlogFacade::getSlug($request->validated('title'));

        $blog_slug_model = BlogModel::bySlug($slug);
        //如果slug不存在
        if (!empty($blog_slug_model)) {
            $slug = $slug . '-' . NanoIdFacade::generate();
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
            'status' => BlogStatus::Publish->value,
            'featured_image_url' => $request->validated('featured_image_url'),
            'slug' => $slug,
            'title' => $request->validated('title'),
            'excerpt' => $request->validated('excerpt'),
            'content' => $request->validated('content'),
            'token' => $request->validated('token'),
        ]);


        return to_route('admin.blog.edit.show', [
            'hash' => $blog_model->hash,
        ]);
    }

    function edit(Request $request)
    {
        $hash = $request->get('hash');
        $blog_model = BlogModel::byHash($hash);

        if (empty($blog_model)) {
            return to_route('admin.blog.index');
        }

        return Inertia::renderVue('Blog/Admin/Edit', [
            'blog' => $blog_model
        ]);
    }

    function update(BlogCrudRequest $request)
    {
        $action = BlogCrudActions::from($request->validated('action'));
        if ($action !== BlogCrudActions::Edit) {
            return Inertia::renderVue('Blog/Admin/Edit', [
                'error' => 'Invalid action for this blog',
            ]);
        }

        $blog_model = BlogModel::byHashOrFail($request->validated('hash'));

        $blog_slug_model = BlogModel::bySlug($request->validated('slug'));
        if (!empty($blog_slug_model) && $blog_slug_model->getKey() !== $blog_model->getKey()){
            return Inertia::renderVue('Blog/Admin/Edit', [
                'blog' => $blog_model,
                'error' => 'Duplicated slug, please choose another one!',
            ]);
        }

        $blog_model->title = $request->validated('title');
        $blog_model->excerpt = $request->validated('excerpt');
        $blog_model->content = $request->validated('content');
        $blog_model->featured_image_url = $request->validated('featured_image_url');
        $blog_model->slug = $request->validated('slug');

        if ($blog_model->save()){
            $status = 'success';
            $message = 'Update blog post successfully!';
        }else{
            $status = 'error';
            $message = 'Update blog post error!';
        }

        return Inertia::renderVue('Blog/Admin/Edit', [
            'blog' => $blog_model,
            'status' => $status,
            'message' => $message,
        ]);

    }
}