<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Validation\Factory as IValidatorFactory;

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
}
