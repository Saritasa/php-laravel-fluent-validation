<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\Factory as IValidatorFactory;
use Propaganistas\LaravelPhone\PhoneServiceProvider;

/**
 * Service provider substitutes default Laravel's validation factory
 * @see FluentValidatorFactory
 */
class FluentValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(IValidatorFactory::class, FluentValidatorFactory::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(PhoneServiceProvider::class);
    }
}
