<?php


use Brucelwayne\Blog\Controllers\BlogController;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['web', 'localizationRedirect'])
    ->prefix(LaravelLocalization::setLocale())
    ->group(function () {
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
//        Route::get('blog/page/{page?}',[BlogController::class, 'index'])->where('page','[1-9]+[0-9]*');
        Route::get('blog/post', [BlogController::class, 'singleByHash'])->name('blog.single.hash');
        Route::get('blog/{slug}', [BlogController::class, 'singleBySlug'])
            ->name('blog.single.slug')
            ->where('slug', '[a-zA-Z0-9-]+');
    });
