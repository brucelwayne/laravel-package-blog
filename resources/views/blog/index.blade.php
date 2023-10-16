@extends('layouts.www',['title'=>'Blog'])

@section('content')
    <div class="blogs py-10 flex-1 h-full">
        <div class="max-w-screen-md mx-auto space-y-4">
            @if(!empty($blogs))
                @foreach($blogs as $blog)
                    <section class="bg-white rounded shadow p-6">

                        <div class="flex flex-row justify-start items-start">
                            <div class="w-1/2">
                                <a href="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl($blog->singleUrl())}}">
                                    @if(!empty($blog['image']['url']))
                                        <img src="{{$blog['image']['url']}}" alt="{{$blog->title}}"/>
                                    @endif
                                </a>
                            </div>
                            <div class="px-6">
                                <a class="text-gray-800 hover:text-blue-600 hover:underline underline-offset-4"
                                        href="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl($blog->singleUrl())}}">
                                    <h2 class="text-2xl heading capitalize">
                                        {{$blog['title'] ?? 'Untitled blog post'}}
                                    </h2>
                                </a>
                                <p class="mt-4">
                                    {{$blog['excerpt']}}
                                </p>
                            </div>
                        </div>
                    </section>
                @endforeach
            @endif
        </div>

        <div class="pagination max-w-screen-md mx-auto mt-10">
            {{$blogs->links()}}
        </div>
    </div>

@endsection