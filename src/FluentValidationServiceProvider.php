<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\ValidationServiceProvider;
use Propaganistas\LaravelPhone\PhoneServiceProvider;

/**
 * Service provider substitutes default Laravel's validation factory
 *
 * @see FluentValidatorFactory
 */
class FluentValidationServiceProvider extends ValidationServiceProvider
{
    protected function registerValidationFactory()
    {
        $this->app->singleton('validator', function ($app) {
            $validator = new FluentValidatorFactory($app['translator'], $app);

            // The validation presence verifier is responsible for determining the existence of
            // values in a given data collection which is typically a relational database or
            // other persistent data stores. It is used to check for "uniqueness" as well.
            if (isset($app['db'], $app['validation.presence'])) {
                $validator->setPresenceVerifier($app['validation.presence']);
            }

            return $validator;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->app->register(PhoneServiceProvider::class);
    }
}
