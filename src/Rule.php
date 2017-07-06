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
 * @method static GenericRuleSet nullable() The field under validation may be null. This is particularly useful when validating primitive such as strings and integers that can contain null values.
 * @method static GenericRuleSet present() The field under validation must be present in the input data but can be empty.
 * @method static GenericRuleSet same(string $anotherFiled) The given field must match the field under validation.
 * @method static GenericRuleSet size(int $value) The field under validation must have a size matching the given value. For string data, value corresponds to the number of characters. For numeric data, value corresponds to a given integer value. For an array, size corresponds to the count of the array. For files, size corresponds to the file size in kilobytes.
 * @method static GenericRuleSet min($minValue) The field under validation must have a minimum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
 * @method static GenericRuleSet max($maxValue) The field under validation must be less than or equal to a maximum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
 * @method static GenericRuleSet inArray(string $anotherField) The field under validation must exist in $anotherField's values.
 * @method static GenericRuleSet requiredWith(string ...$otherFields) This field is required, if another field has value
 * @method static GenericRuleSet requiredWithAll(string ...$otherFields) The field under validation must be present and not empty only if all of the other specified fields are present.
 * @method static GenericRuleSet requiredWithout(string ...$otherFields) This field is required, if another field has no value
 * @method static GenericRuleSet requiredWithoutAll(string ...$otherFields) The field under validation must be present and not empty only when all of the other specified fields are not present.
 * @method static GenericRuleSet requiredIf(string $anotherField, $value) The field under validation must be present and not empty if the $anotherField field is equal to any value.
 * @method static GenericRuleSet requiredUnless(string $anotherField, $value) The field under validation must be present and not empty unless the $anotherField field is equal to any value.
 * @method static GenericRuleSet timezone() The field under validation must be a valid timezone identifier according to the  timezone_identifiers_list PHP function.
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

    /**
     * The field under validation must be an integer.
     * @return IntRuleSet
     */
    static function int(): IntRuleSet
    {
        return new IntRuleSet();
    }

    /**
     * The field under validation must be numeric.
     * @return NumericRuleSet
     */
    static function numeric(): NumericRuleSet
    {
        return new NumericRuleSet();
    }

    /**
     * The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field.
     * @return StringRuleSet
     */
    static function string(): StringRuleSet
    {
        return new StringRuleSet();
    }

    /**
     * The field under validation must be a successfully uploaded file.
     * @return FileRuleSet
     */
    static function file(): FileRuleSet
    {
        return new FileRuleSet();
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
