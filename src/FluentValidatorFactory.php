<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Validation\Factory as LaravelValidatorFactory;

/**
 * Converts fluent validation rules to strings before validation
 * It allows not to call ->toString explicitly
 */
class FluentValidatorFactory extends LaravelValidatorFactory
{
    /**
     * Create a new Validator instance.
     *
     * @param  array  $data Input data to validate
     * @param  array  $rules Set of validation rules
     * @param  array  $messages Custom messages for validation rules
     * @param  array  $customAttributes Human-readable attribute names for validated attributes
     * @return \Illuminate\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $rules = array_map(function ($rule) {
            return $rule instanceof IRule ? strval($rule) : $rule;
        }, $rules);

        return parent::make($data, $rules, $messages, $customAttributes);
    }
}
