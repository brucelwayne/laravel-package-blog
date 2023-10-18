<?php

namespace Brucelwayne\Blog\Controllers;

use App\Http\Controllers\Controller;
use Brucelwayne\Admin\Models\AdminModel;
use Brucelwayne\Blog\Enums\BlogCrudActions;
use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Enums\BlogType;
use Brucelwayne\Blog\Facades\BlogFacade;
use Brucelwayne\Blog\Models\BlogModel;
use Brucelwayne\Blog\Requests\BlogCrudRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mallria\Core\Enums\PostStatus;
use Mallria\Core\Facades\Inertia;
use Mallria\Core\Facades\NanoIdFacade;
use Mallria\Core\Http\Responses\ErrorJsonResponse;
use Mallria\Core\Http\Responses\SuccessJsonResponse;
use Mallria\Media\Models\MediaModel;

class AdminController extends Controller
{
    function index()
    {
        $blog_models = BlogModel::where('team_id', 0)
            ->orderBy('id', 'DESC')
            ->paginate(10);

//        return view('blog::blog.admin.index', [
//            'blogs' => $blog_models,
//        ]);
//        return Inertia::renderVue('Blog/Admin/Index',[
//            'blogs' => $blog_models,
//        ]);
        return Inertia::render('Blog/Admin/List', [
            'blogs' => $blog_models,
            'aside' => [
                'openKeys' => ['blog'],
                'selectedKeys' => ['blog-posts'],
            ],
        ]);
    }

//    function single(Request $request)
//    {
//        $hash = $request->get('hash');
//    }

    function create(Request $request)
    {
//        $hash = $request->get('hash');
//        if (empty($hash)) {
//            /**
//             * @var AdminModel $admin_model
//             */
//            $admin_model = auth()->guard('admin')->user();
//            $blog_model = BlogModel::createDraft($admin_model->getKey());
//            return redirect()->to(route('admin.blog.edit.show', ['hash' => $blog_model->hash]));
//        }
//        else {
//            $blog_model = BlogModel::byHashOrFail($hash);
//            return view('blog::blog.admin.create', [
//                'blog' => $blog_model,
//            ]);
//        }

//        return view('blog::blog.admin.create');
//        return Inertia::renderVue('Blog/Admin/Create');
        return Inertia::render('Blog/Admin/Create', [
            'aside' => [
                'openKeys' => ['blog'],
                'selectedKeys' => ['blog-create'],
            ],
        ]);
    }

    function store(BlogCrudRequest $request)
    {
        $crud = BlogCrudActions::from($request->validated('crud'));
        if ($crud !== BlogCrudActions::Create) {
            return redirect()->back()->withInput($request->input());
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

        $stats = BlogStatus::from($request->validated('status'));
        $type = BlogType::from($request->validated('type'));

        $image_id = empty($request->validated('image')) ? null : MediaModel::hashToId($request->validated('image'));
        $video_id = empty($request->validated('video')) ? null : MediaModel::hashToId($request->validated('video'));
        $gallery_ids = empty($request->validated('gallery')) ? null : collect($request->validated('gallery'))->map(function ($g) {
            return MediaModel::hashToId($g);
        })->toArray();

        $blog_model = BlogModel::create([
            'team_id' => 0,//system blog is 0
            'creator_id' => $admin->getKey(),
            'author_id' => $admin->getKey(),
            'cate_id' => 0, // no category for now

            'status' => $stats->value,
            'type' => $type->value,
            'locale' => $request->validated('locale'),

            'slug' => $slug,
            'title' => $request->validated('title'),
            'excerpt' => $request->validated('excerpt'),
            'content' => $request->validated('content'),

            'seo_title' => $request->validated('seo_title'),
            'seo_keywords' => $request->validated('seo_keywords'),
            'seo_description' => $request->validated('seo_description'),

            'image_id' => $image_id,
            'gallery_ids' => $gallery_ids,
            'video_id' => $video_id,
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

//        return view('blog::blog.admin.edit', [
//            'blog' => $blog_model
//        ]);

        $blog_model->load(['image']);

        return Inertia::renderVue('Blog/Admin/Edit', [
            'blog' => $blog_model,
            'aside' => [
                'openKeys' => ['blog'],
                'selectedKeys' => ['blog-create'],
            ],
        ]);
    }

    function update(BlogCrudRequest $request)
    {

        $blog_model = BlogModel::byHashOrFail($request->validated('hash'));

        $crud = BlogCrudActions::from($request->validated('crud'));
        if ($crud !== BlogCrudActions::Edit) {
            return redirect()->back()->withInput($request->input())
                ->withErrors('Invalid action for this blog!')
                ->with('blog', $blog_model);
        }
        $title = $request->validated('title');
        $slug = $request->validated('slug');
        if (empty($slug)) {
            if (!empty($title)) {
                $slug = BlogFacade::getSlug($title);
            }
        } else {
            $slug = BlogFacade::getSlug($request->validated('slug'));
        }
        $blog_slug_model = BlogModel::bySlug($slug);
        if (!empty($blog_slug_model) && $blog_slug_model->getKey() !== $blog_model->getKey()) {
//            return redirect()->back()->withInput($request->input())
//                ->withErrors('Duplicated slug, please choose another one!')
//                ->with('blog', $blog_model);
            return Inertia::renderVue('Blog/Admin/Edit', [
                'error' => 'Duplicated slug, please choose another one!',
                'blog' => $blog_model,
            ]);
        }

        $image_hash = $request->validated('image');
        if (!empty($image_hash)) {
            $media_model = MediaModel::byHash($image_hash);
        }

        $stats = BlogStatus::from($request->validated('status'));

        $blog_model->title = $title;
        $blog_model->excerpt = $request->validated('excerpt');
        $blog_model->content = $request->validated('content');
        $blog_model->slug = $slug;
        $blog_model->status = $stats->value;
        $blog_model->image_id = empty($media_model) ? 0 : $media_model->getKey();

        if ($blog_model->save()) {
            $status = 'success';
            $message = 'Update blog post successfully!';
        } else {
            $status = 'error';
            $message = 'Update blog post error!';
        }


        return redirect()->back()
            ->with('blog', $blog_model)
            ->with([
                'status' => $status,
                'message' => $message,
            ]);

    }

    function updateStatus(Request $request)
    {
        $hash = $request->get('hash');
        $status = $request->get('status');

        $blog_model = BlogModel::byHashOrFail($hash);
        $blog_model->status = $status ? BlogStatus::Publish : BlogStatus::Draft;
        if ($blog_model->save()) {
            return new SuccessJsonResponse([], 'Update blog post successfully!');
        } else {
            return new ErrorJsonResponse('Update blog post error!');
        }
    }

    function delete(Request $request)
    {
        $hash = $request->get('hash');
        $blog_model = BlogModel::byHashOrFail($hash);
        if ($blog_model->delete()) {
            return new SuccessJsonResponse([], 'Delete blog post successfully!');
        } else {
            return new ErrorJsonResponse('Delete blog post error!');
        }
    }
}