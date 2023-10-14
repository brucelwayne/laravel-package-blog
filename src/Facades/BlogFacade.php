<?php

namespace Brucelwayne\Blog\Facades;

use Brucelwayne\Blog\Contracts\IBlogService;
use QCod\Settings\Facade;


/**
 * @method static string getSlug($title,$length = 190)
 */
class BlogFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IBlogService::class;
    }
}