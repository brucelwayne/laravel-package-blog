<?php

use Brucelwayne\Blog\Enums\BlogStatus;
use Brucelwayne\Blog\Enums\BlogType;
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

            $table->string('locale')->default(config('app.locale'))->index();
            $table->string('type')->default(BlogType::Classic->value)->index();
            $table->string('status')->default(BlogStatus::Draft->value)->index();

            $table->integer('cate_id')->default(0)->index();

            $table->integer('image_id')->nullable();
            $table->text('gallery_ids')->nullable();
            $table->integer('video_id')->nullable();

            $table->longText('slug')->nullable();

            $table->longText('title')->nullable();
            $table->longText('excerpt')->nullable();
            $table->longText('content')->nullable();

            $table->longText('seo_title')->nullable();
            $table->longText('seo_keywords')->nullable();
            $table->longText('seo_description')->nullable();

            $table->timestamps();

        });

        Schema::create('blog_revisions', function ($table) {
            /**
             * @var Illuminate\Database\Schema\Blueprint|MongoDB\Laravel\Schema\Blueprint $table
             */
            $table->increments('id');
            $table->integer('blog_id')->index();
            $table->json('payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_revisions');
    }
};
