<?php

namespace Brucelwayne\Blog\Services;

use Ausi\SlugGenerator\SlugGenerator;
use Brucelwayne\Blog\Contracts\IBlogService;
use Illuminate\Support\Str;

class BlogService implements IBlogService
{

    function getSlug(string $title, $length = 190): string
    {
        $generator = new SlugGenerator();
        $slug =  $generator->generate($title);
        return Str::substr($slug,0,$length);
    }
}