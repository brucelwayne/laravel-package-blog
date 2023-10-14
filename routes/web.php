<?php


use Brucelwayne\Blog\Controllers\BlogController;
use Brucelwayne\Blog\Models\BlogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->group(function(){
        Route::get('blog',function(){
            var_dump(1);exit;
        })->name('blog.index');
        Route::get('blog/{slug}', [BlogController::class,'index'])->name('blog.single');
    });