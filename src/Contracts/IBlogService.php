<?php

namespace Brucelwayne\Blog\Contracts;

interface IBlogService
{
    function getSlug(string $title,$length = 190);

}