<?php
    use \Mcamara\LaravelLocalization\Facades\LaravelLocalization
    /**
     * @var \Brucelwayne\Blog\Models\BlogModel $blog
     */
?>

@php($currentLocale = LaravelLocalization::getCurrentLocale())

@extends('layouts.www',['title'=>$blog->title])

@section('content')
    <div class="py-10 h-full">

        <div class="max-w-screen-md mx-auto mb-4 px-6 flex flex-row justify-between items-center">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{route('welcome')}}"
                           class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            Mallria
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <a href="{{LaravelLocalization::localizeUrl(route('blog.index'))}}"
                               class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                                Blog
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>
            <div>
                <button data-dropdown-toggle="language-dropdown"
                        class="text-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center "
                        type="button">
                    {{LaravelLocalization::getCurrentLocaleNative()}}
                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 1 4 4 4-4"/>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="language-dropdown"
                     class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-gray-700 w-auto" aria-labelledby="dropdownDefaultButton">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                   class="capitalize whitespace-nowrap block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                   href="{{LaravelLocalization::getLocalizedURL($localeCode, $blog->getUrl($localeCode), [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div style="
        @if(!empty($blog['image']['url']))
        background-image:url('{{$blog['image']['url']}}');
        @endif
        " class="bg-no-repeat bg-cover bg-center max-w-screen-md mx-auto rounded">
            <div class="bg-[#00000060] px-10 py-[100px] text-white rounded-t">
                <div class="blog-single-head text-center">
                    <h1 class="heading text-5xl font-semibold capitalize">
                        {{empty($blog->title) ? 'Untitled blog post':$blog->title}}
                    </h1>
                </div>
                <div class="blog-single-meta mt-4 text-right text-gray-100">
                    {{\Carbon\Carbon::parse($blog->updated_at)->toFormattedDateString()}}
                </div>
            </div>
        </div>
        <div class="blog-single-content max-w-screen-md mx-auto p-10 bg-white rounded-b">
            <div>
                {{$blog->excerpt}}
            </div>
            <div class="fr-view">
                @php($content = $blog->getTranslation('content',$currentLocale))
                {!! $blog->content !!}
            </div>
        </div>
    </div>
    @push('styles')

        <style>
            .blog-single-content img {
                max-width: 100% !important;
            }
        </style>
    @endpush
@endsection