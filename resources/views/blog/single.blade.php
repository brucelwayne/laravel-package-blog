@extends('layouts.www',['title'=>$blog->title])

@section('content')
    <div>
        <h1>
            {{$blog->title}}
        </h1>
        <div>
            <img src="{{$blog->featured_image_url}}" alt="{{$blog->title}}" />
        </div>
        <div>
            {{$blog->excerpt}}
        </div>
        <div>
            {!! $blog->content !!}
        </div>
    </div>
@endsection