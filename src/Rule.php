<?php

namespace Saritasa\Laravel\Validation;

use Saritasa\Exceptions\NotImplementedException;

/**
 * Root builder for validation rules
 *
 * @method static FileRuleSet dimensions(array $constraints) Get a dimensions constraint builder instance.
 * @method static DatabaseRuleSet exists(string $table, string $column, \Closure $closure = null) Get a exists constraint builder instance.
 * @method static GenericRuleSet in(... $values) The field under validation must be included in the given list of values.
 * @method static GenericRuleSet notIn(... $values) The field under validation must not be included in the given list of values.
 * @method static GenericRuleSet inArray(string $anotherField) The field under validation must exist in $anotherField's values.
 * @method static GenericRuleSet requiredWith(string ...$otherFields) This field is required, if another field has value
 * @method static GenericRuleSet requiredWithAll(string ...$otherFields) The field under validation must be present and not empty only if all of the other specified fields are present.
 * @method static GenericRuleSet requiredWithout(string ...$otherFields) This field is required, if another field has no value
 * @method static GenericRuleSet requiredWithoutAll(string ...$otherFields) The field under validation must be present and not empty only when all of the other specified fields are not present.
 * @method static GenericRuleSet requiredIf(string $anotherField, $value) The field under validation must be present and not empty if the $anotherField field is equal to any value.
 * @method static GenericRuleSet requiredUnless(string $anotherField, $value) The field under validation must be present and not empty unless the $anotherField field is equal to any value.
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
        } elseif (in_array($name, DatabaseRuleSet::EXPOSED_RULES)) {
            $ruleSet = new DatabaseRuleSet();
        } elseif (in_array($name, GenericRuleSet::EXPOSED_RULES)
            || in_array($name, RuleSet::BASIC_RULES)) {
            $ruleSet = new GenericRuleSet();
        } else {
            throw new NotImplementedException("Requested unknown rule $name");
        }
        return call_user_func_array([$ruleSet, $name], $arguments);
    }
}
