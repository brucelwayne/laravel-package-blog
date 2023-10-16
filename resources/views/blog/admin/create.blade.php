@extends('admin::layouts.admin',['title'=>'Create a New Blog Post'])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>'Create a New Blog Post'],
        'form'=>[
            'title'=>'',
            'excerpt'=>'',
            'content' => '',
            'image'=>'',
            'action'=>'create',
            'status'=>'draft',
         ],
    ])
@endsection