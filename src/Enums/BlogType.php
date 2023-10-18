<?php
namespace Brucelwayne\Blog\Enums;

enum BlogType:string{
    case Classic = 'classic';
    case Gallery = 'gallery';
    case Video = 'video';
}