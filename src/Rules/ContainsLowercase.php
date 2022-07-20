<?php

namespace Saritasa\Laravel\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * The rule to check for a lowercase letter in a string.
 */
class ContainsLowercase implements Rule
{
    const REGEX = '/([\p{Ll}]+)/u';

    /**
     * Determine if the validation rule passes.
     *
     * @param mixed $attribute The name of the attribute
     * @param mixed $value The value of the attribute
     *
     * @return boolean
     */
    public function passes($attribute, $value): bool
    {
        return $attribute && preg_match(self::REGEX, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'At least one lowercase letter';
    }
}
