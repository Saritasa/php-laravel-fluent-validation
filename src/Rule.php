<?php

namespace Saritasa\Laravel\Validation;

/**
 * Root builder for validation rules
 *
 * @method static FileRuleSet dimensions(array $constraints)
 * @method static DatabaseRuleSet exists(string $table, string $column)
 * @method 
 */
class Rule
{
    /**
    The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true:

    The value is null.
    The value is an empty string.
    The value is an empty array or empty Countable object.
    The value is an uploaded file with no path.
     */
    static function required(): GenericRuleSet
    {
        return (new GenericRuleSet())->required();
    }

    static function int(): IntRuleSet
    {
        return new IntRuleSet();
    }

    static function numeric(): NumericRuleSet
    {
        return new NumericRuleSet();
    }

    static function string(): StringRuleSet
    {
        return new StringRuleSet();
    }

    public static function __callStatic($name, $arguments)
    {
        $ruleSet = null;
        if (in_array($name, StringRuleSet::EXPOSED_RULES)) {
            $ruleSet = new StringRuleSet();
        } elseif (in_array($name, IntRuleSet::EXPOSED_RULES)) {
            $ruleSet = new IntRuleSet();
        }
        $ruleSet->$name($arguments);
    }
}
