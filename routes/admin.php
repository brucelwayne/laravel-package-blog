<?php

use Brucelwayne\Blog\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/blog')->name('admin.blog.')
    ->middleware(['web','auth:admin'])
    ->group(function(){

    //admin index page
    Route::get('/',[AdminController::class,'index'])->name('index');
});