<?php


use Brucelwayne\Blog\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['web', 'tenant:guest', 'localizationRedirect'])
    ->prefix(LaravelLocalization::setLocale())
    ->group(function () {
        Route::prefix('blog')->group(function(){
            Route::get('/', [BlogController::class, 'index'])->name('blog.index');
            Route::get('{hash}/{slug?}', [BlogController::class, 'singleByHash'])->name('blog.single')
                ->where('hash','[a-zA-Z0-9-]+')
                ->where('slug','[a-zA-Z0-9-]+');
        });
    });
