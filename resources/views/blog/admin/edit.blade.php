@extends('admin::layouts.admin',['title'=>'Edit Blog Post'])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>'Edit Blog Post'],
        'form' => [
            'action'=>route('admin.blog.edit.update',['hash'=>$blog['hash']]),
        ],
        'instance'=>[
            'slug' => $blog['slug'],
            'title'=>$blog['title'],
            'excerpt'=>$blog['excerpt'],
            'content' => $blog['content'],
            'image'=>$blog['image'],
            'crud'=> \Brucelwayne\Blog\Enums\BlogCrudActions::Edit->value,
            'status'=> $blog['status'],
         ],
    ])
@endsection