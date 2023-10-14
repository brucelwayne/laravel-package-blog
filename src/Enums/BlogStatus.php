<?php
namespace Brucelwayne\Blog\Enums;

enum BlogStatus:string{
    case DRAFT = 'draft';
    case PUBLISH = 'publish';
}