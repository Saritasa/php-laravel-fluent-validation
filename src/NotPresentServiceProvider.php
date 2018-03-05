<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Validation\Rule;
use Saritasa\Laravel\Validation\Rules\NotPresent;

class NotPresentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidator();
        $this->registerRule();
    }

    /**
     * Register the "not_present" validator.
     */
    protected function registerValidator()
    {
        /** @var FluentValidatorFactory $validator */ //@codingStandardsIgnoreLine
        $validator = $this->app['validator'];
        $validator->extendImplicit(NotPresent::RULE_NAME, NotPresent::class . '@validate');
        $validator->replacer(NotPresent::RULE_NAME, NotPresent::class . '@message');
    }

    /**
     * Register the "not_present" rule macro.
     */
    protected function registerRule()
    {
        if (class_exists('Illuminate\Validation\Rule') && class_uses(Rule::class, Macroable::class)) {
            Rule::macro('not_present', function () {
                return new Rules\NotPresent();
            });
        }
    }
}
