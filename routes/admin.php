<?php

use Brucelwayne\Blog\Controllers\AdminController;
use Brucelwayne\Blog\Controllers\MediaController;
use Brucelwayne\Blog\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/blog')->name('admin.blog.')
    ->middleware(['web', 'auth:admin','inertia'])
    ->group(function () {

        //admin index page
        Route::get('/', [AdminController::class, 'index'])->name('index');

//        Route::get('single', [AdminController::class, 'single'])->name('single.show');

        Route::get('create', [AdminController::class, 'create'])->name('create.show');
        Route::post('create', [AdminController::class, 'store'])
            ->name('create.store');

        Route::get('edit', [AdminController::class, 'edit'])->name('edit.show');
        Route::post('edit', [AdminController::class, 'update'])
            ->name('edit.update');

        Route::put('edit/status',[AdminController::class, 'updateStatus'])
            ->name('edit.put.status');

        Route::delete('delete', [AdminController::class, 'delete'])->name('delete');

        Route::get('cates', [AdminController::class, 'index'])->name('cates.show');

        Route::get('tags', [AdminController::class, 'index'])->name('tags.show');

        Route::prefix('file')->name('file.')->group(function () {
            Route::post('upload',[MediaController::class,'upload'])->name('upload');
        });

    });
