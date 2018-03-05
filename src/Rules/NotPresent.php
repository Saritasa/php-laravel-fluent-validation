<?php

namespace Saritasa\Laravel\Validation\Rules;

use Illuminate\Validation\Validator;
use Saritasa\Laravel\Validation\IRule;

/**
 * Not present validation for a field.
 */
class NotPresent implements IRule
{
    const RULE_NAME = 'not_present';

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return self::RULE_NAME;
    }

    /**
     * Get the validation error message.
     *
     * @param string $message Message
     * @param string $attribute Attribute name
     *
     * @return string
     */
    public function message($message, $attribute)
    {
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
        $data = $validator->getData();
        return ! array_has($data, $attribute);
    }
}
