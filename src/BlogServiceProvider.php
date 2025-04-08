<?php

namespace Brucelwayne\Blog;

use Brucelwayne\Blog\Contracts\IBlogService;
use Brucelwayne\Blog\Services\BlogService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected string $module_name = 'blog';

    public function register()
    {

    }

    public function boot()
    {
        $this->bootFacades();
        $this->bootConfigs();
        $this->bootRoutes();
        $this->bootMigrations();
        $this->bootComponentNamespace();
        $this->loadBladeViews();
    }

    protected function bootFacades(): void
    {
        $this->app->singleton(IBlogService::class, function () {
            return new BlogService();
        });
    }

    protected function bootConfigs(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/blog.php', $this->module_name
        );
    }

    protected function bootRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function bootComponentNamespace(): void
    {
        Blade::componentNamespace('Brucelwayne\\Blog\\View\\Components', $this->module_name);
    }

    protected function loadBladeViews(): void
    {
//        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->module_name);
    }
}