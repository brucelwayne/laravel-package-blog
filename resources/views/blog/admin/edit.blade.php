@php($title = 'Blog Post')

@extends('admin::layouts.admin',['title'=>$title])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>$title],
        'form' => [
            'action'=>route('admin.blog.edit.update',['hash'=>$blog['hash']]),
            'crud'=> \Brucelwayne\Blog\Enums\BlogCrudActions::Edit->value,
        ],
        'instance'=>$blog
    ])
@endsection