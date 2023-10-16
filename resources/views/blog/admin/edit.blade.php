@extends('admin::layouts.admin',['title'=>'Edit Blog Post'])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>'Edit Blog Post'],
        'form'=>[
            'title'=>$blog['title'],
            'excerpt'=>$blog['excerpt'],
            'content' => $blog['content'],
            'image'=>$blog['image'],
            'action'=>'create',
            'status'=>'draft',
         ],
    ])
@endsection