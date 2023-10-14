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
            $table->integer('default_cate_id')->default(0)->index();
            $table->string('status')->default(BlogStatus::DRAFT->value)->index();

            $table->string('slug')->index();

            $table->text('title');
            $table->text('excerpt');
            $table->text('content');

            $table->text('seo_title');
            $table->text('seo_keywords');
            $table->text('seo_description');

            $table->string('token', 21)->unique();
            $table->timestamps();
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
