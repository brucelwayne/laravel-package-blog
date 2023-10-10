<?php

namespace Brucelwayne\Blog;

use Brucelwayne\Blog\Contracts\IBlogService;
use Brucelwayne\Blog\Services\BlogService;
use Illuminate\Support\ServiceProvider;
use Mallria\Core\Contracts\WordpressWebhookContract;
use Mallria\Core\Services\WordpressWebhookService;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->bootFacades();
    }

    protected function bootFacades(): void
    {
        $this->app->singleton(IBlogService::class, function () {
            return new BlogService();
        });
    }
}