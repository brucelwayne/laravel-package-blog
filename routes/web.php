<?php


use Brucelwayne\Blog\Controllers\BlogController;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['web'])
    ->prefix(LaravelLocalization::setLocale())
    ->group(function () {
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
//        Route::get('blog/page/{page?}',[BlogController::class, 'index'])->where('page','[1-9]+[0-9]*');
        Route::get('blog/{slug}', [BlogController::class, 'single'])
            ->name('blog.single')
            ->where('slug', '[a-zA-Z0-9-]+');
    });
