<?php

use Brucelwayne\Blog\Enums\BlogStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    protected $connection = 'mysql';

    public function up(): void
    {
        Schema::create('blogs', function ($table) {
            /**
             * @var Illuminate\Database\Schema\Blueprint|MongoDB\Laravel\Schema\Blueprint $table
             */
            $table->increments('id');
            $table->integer('team_id')->default(0)->index();
            $table->integer('creator_id')->index();
            $table->integer('author_id')->default(0)->index();

            $table->text('featured_image_url');
            $table->integer('cate_id')->default(0)->index();

            $table->string('status')->default(BlogStatus::DRAFT->value)->index();

            $table->string('slug');

            $table->text('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('content')->nullable();

            $table->text('seo_title')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();

            $table->timestamps();

            $table->unique(['team_id', 'slug'], 'team_id_slug');
        });

        Schema::create('blog_revisions', function ($table) {
            /**
             * @var Illuminate\Database\Schema\Blueprint|MongoDB\Laravel\Schema\Blueprint $table
             */
            $table->increments('id');
            $table->integer('blog_id')->index();
            $table->integer('author_id');
            $table->integer('default_cate_id');
            $table->integer('category_ids');
            $table->string('slug');
            $table->text('title');
            $table->text('excerpt');
            $table->text('content');

            $table->text('seo_title');
            $table->text('seo_keywords');
            $table->text('seo_description');

            $table->string('token', 21)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_revisions');
    }
};
