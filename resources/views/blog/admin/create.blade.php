@extends('admin::layouts.admin',['title'=>'Create a New Blog Post'])

@section('content')
    @include('blog::components.blog-form',[
        'page'=>['heading'=>'Create a New Blog Post'],
        'form' => [
            'action'=>route('admin.blog.create.show'),
        ],
        'instance'=>[
            'title'=>'',
            'excerpt'=>'',
            'content' => '',
            'image'=>'',
            'crud'=> \Brucelwayne\Blog\Enums\BlogCrudActions::Create->value,
            'status'=> \Mallria\Core\Enums\PostStatus::Draft->value,
         ],
    ])
@endsection