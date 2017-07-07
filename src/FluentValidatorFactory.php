<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\Factory as LaravelValidatorFactory;

/**
 * Converts fluent validation rules to strings before validation
 * It allows not to call ->toString explicitly
 */
class FluentValidatorFactory extends LaravelValidatorFactory
{
    /** @inheritdoc */
    public function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $rules = array_map(function($rule) {
            return $rule instanceof IRule ? strval($rule) : $rule;
        }, $rules);

        return parent::make($data, $rules, $messages, $customAttributes);
    }
}
