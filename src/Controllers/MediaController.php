<?php

namespace Brucelwayne\Blog\Controllers;

use Brucelwayne\Admin\Models\AdminUserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mallria\Core\Http\Controllers\BaseController;
use Mallria\Core\Http\Responses\SuccessJsonResponse;
use Mallria\Media\Enums\MediaCollectionNames;

class MediaController extends BaseController
{
    function upload(Request $request)
    {
//        $blog_hash = $request->get('blog');
//        if (!empty($blog_hash)){
//            $blog_model = BlogModel::byHashOrFail($blog_hash);
//            $media = $blog_model->addMediaFromRequest('upload')
//                ->usingFileName(Str::ulid() . '.' . $request->file('upload')->extension())
//                ->toMediaCollection(MediaCollectionNames::Blog->value);
//            return new SuccessJsonResponse(['media' => $media]);
//        }

        /**
         * @var AdminUserModel $admin_model
         */
        $admin_model = auth()->guard('admin')->user();
        if (!empty($admin_model)) {
            $media = $admin_model->addMediaFromRequest('upload')
                ->usingFileName(Str::ulid() . '.' . $request->file('upload')->extension())
                ->toMediaCollection(MediaCollectionNames::Media->value);
            return new SuccessJsonResponse(['media' => $media]);
        }
    }
}
