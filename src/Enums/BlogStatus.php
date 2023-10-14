<?php
namespace Brucelwayne\Blog\Enums;

enum BlogStatus:string{
    case Draft = 'draft';
    case Publish = 'publish';
}