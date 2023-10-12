<?php

return [
    'guard' => [
        'admin' => 'user',
    ],
    'permissions' => [
        'blog-read',
        'blog-write',
        'blog-update',
        'blog-delete',
    ],
    'roles' => [
        'blog-admin',
        'blog-editor',
        'blog-contributor',
    ],
];