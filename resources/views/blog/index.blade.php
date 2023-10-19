<?php
    use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/**
 * @var \Brucelwayne\Blog\Models\BlogModel $blog
 */
?>
@php($currentLocale = LaravelLocalization::getCurrentLocale())

@extends('layouts.www',['title'=>'Blog'])

@section('content')


    <div class="blogs py-10 flex-1 h-full">
        <div class="max-w-screen-md mx-auto space-y-4">
            @if(!empty($blogs))

                @foreach($blogs as $blog)
                    <section class="bg-white rounded shadow p-6">
                        <div class="flex flex-row justify-start items-start">
                            <div class="w-1/2">
                                <a class="relative group"
                                        href="{{LaravelLocalization::localizeUrl($blog->getUrl())}}">
                                    @if(!empty($blog['image']['url']))
                                        <img class="rounded-lg" src="{{$blog['image']['url']}}" alt="{{$blog->title}}"/>
                                    @endif
                                    <div class="w-full h-full rounded-lg left-0 top-0 absolute z-10 group-hover:bg-[#00000040] transition-all ease-in-out"></div>
                                </a>
                            </div>
                            <div class="px-6">
                                <a class="text-gray-800 hover:text-blue-600 hover:underline underline-offset-4"
                                        href="{{LaravelLocalization::localizeUrl($blog->getUrl())}}">
                                    <h2 class="text-lg font-medium">
                                        {{empty($blog->title) ? 'Untitled blog post':$blog->title}}
                                    </h2>
                                </a>
                                <p class="mt-4 font-light text-gray-700">
                                    {{$blog->excerpt}}
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