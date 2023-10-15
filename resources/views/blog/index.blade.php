@extends('layouts.www',['title'=>'Blog'])

@section('content')
    <div class="blogs py-10 flex-1 h-full">
        <div class="max-w-screen-md mx-auto space-y-4">
            @if(!empty($blogs))
                @foreach($blogs as $blog)
                    <section class="bg-white rounded shadow p-6">
                        <a href="{{route('blog.single',['slug'=>$blog->slug])}}">
                            <div class="flex flex-row justify-start items-start">
                                <div class="w-1/2">
                                    <img src="{{$blog->featured_image_url}}" alt="{{$blog->title}}" />
                                </div>
                                <div class="px-6">
                                    <h2 class="text-2xl heading">
                                        {{$blog->title}}
                                    </h2>
                                    <p class="mt-4">
                                        {{$blog->excerpt}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </section>
                @endforeach
            @endif
        </div>

        <div class="pagination max-w-screen-md mx-auto mt-10">
            {{$blogs->links()}}
        </div>
    </div>

@endsection