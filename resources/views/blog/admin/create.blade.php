@extends('admin::layouts.admin',['title'=>'Create a New Blog Post'])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>'Create a New Blog Post'],
        'form' => [
            'action'=>route('admin.blog.create.show'),
            'crud'=> \Brucelwayne\Blog\Enums\BlogCrudActions::Create->value,
        ],
        'instance'=>[
            'hash' => '',
            'title'=>'',
            'excerpt'=>'',
            'content'=>'',
            'image'=>'',
            'status'=>\Mallria\Core\Enums\PostStatus::Draft->value,
],
    ])
@endsection