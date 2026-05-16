<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('uppercase_and_trim', function ($attribute, $value, $parameters, $validator) {
            $trimmed = trim($value);
            $ucFirst = ucfirst($trimmed);
            $validator->setData(array_merge($validator->getData(), [$attribute => $ucFirst]));

            return true;
        });
        Validator::extend('lowercase_and_trim', function ($attribute, $value, $parameters, $validator) {
            $trimmed = trim($value);
            $strToLower = strtolower($trimmed);
            $validator->setData(array_merge($validator->getData(), [$attribute => $strToLower]));

            return true;
        });
    }
}
