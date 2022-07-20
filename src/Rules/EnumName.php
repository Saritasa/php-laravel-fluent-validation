<?php

namespace Rules;

use Illuminate\Contracts\Validation\Rule;
use Saritasa\Laravel\Validation\IRule;

class EnumName implements Rule, IRule
{
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    public function passes($attribute, $value)
    {
        // TODO: Implement passes() method.
    }

    public function message()
    {
        // TODO: Implement message() method.
    }
}
