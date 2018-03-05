<?php

namespace Saritasa\Laravel\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Validator;
use Saritasa\Laravel\Validation\IRule;

/**
 * Not present validation for a field.
 */
class NotPresent implements IRule, Rule
{
    /**
     * The name of the rule.
     */
    protected $rule = 'not_present';

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->rule;
    }

    /**
     * Check whether attribute value is set or not.
     *
     * @param  string  $attribute Attribute name
     * @param  mixed  $value Attribute value
     * @return boolean
     */
    public function passes($attribute, $value)
    {
        return is_null($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        list($message, $attribute) = func_get_args();
        return trans("fluent_validation::$message", ['attribute' => $attribute]);
    }

    /**
     * Validates attribute.
     *
     * @param  string $attribute Attribute name
     * @param  mixed  $value Attribute value
     * @param  array  $parameters Parameters for validation
     * @param  Validator $validator Validator object
     * @return boolean
     */
    public function validate($attribute, $value, array $parameters, $validator)
    {
        return $this->passes($attribute, $value);
    }
}
