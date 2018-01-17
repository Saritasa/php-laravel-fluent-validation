<?php

namespace Saritasa\Laravel\Validation\Rules;

use Saritasa\Laravel\Validation\IRule;

class Phone extends \Propaganistas\LaravelPhone\Rules\Phone implements IRule
{
    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString();
    }
}