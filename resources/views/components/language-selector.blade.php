<?php
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
?>
<button data-dropdown-toggle="language-dropdown"
        class="capitalize text-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center "
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