<?php

namespace Brucelwayne\Blog\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LocaleRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $locales = LaravelLocalization::getSupportedLocales();
        if (empty($locales[$value])){
            $fail(trans('Invalid supported locale'));
        }
    }
}