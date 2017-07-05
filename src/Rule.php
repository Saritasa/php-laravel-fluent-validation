<?php

namespace Saritasa\Laravel\Validation;

/**
 * Root builder for validation rules
 */
class Rule
{
    static function required(): GenericRuleSet
    {
        return (new GenericRuleSet())->required();
    }

    static function int(): IntRuleSet
    {
        return new IntRuleSet();
    }

    static function string(): StringRuleSet
    {
        return new StringRuleSet();
    }
}
