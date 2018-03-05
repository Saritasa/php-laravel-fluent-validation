<?php

namespace Saritasa\Laravel\Validation;

use Illuminate\Support\Facades\Config;
use Saritasa\Exceptions\ConfigurationException;
use Saritasa\Laravel\Validation\Rules\NotPresent;

/**
 * Just breakdown of RuleSet, containing too many methods for easy reading
 */
trait SimpleRules
{
    /**
     * The field under validation must exist in anotherField's values.
     *
     * @param string $anotherFiled Field to validate against
     * @return static
     */
    public function inArray(string $anotherFiled)
    {
        return $this->appendIfNotExists("in_array:$anotherFiled");
    }

    /**
     * The field under validation must be included in the given list of values.
     *
     * @param array ...$values List of values to validate against
     * @return static
     */
    public function in(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::in($val));
    }

    /**
     * The field under validation must not be included in the given list of values.
     *
     * @param array ...$values List of values to validate against
     * @return static
     */
    public function notIn(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::notIn($val));
    }

    /**
     * The field under validation must be not present in the input data.
     * @return static
     */
    public function notPresent()
    {
        return $this->appendIfNotExists(new NotPresent());
    }

    /**
     * The given field must match the field under validation.
     *
     * @param string $anotherField Name of field to compare with
     * @return static
     */
    public function same(string $anotherField)
    {
        return $this->appendIfNotExists("same:$anotherField");
    }

    /**
     * The field under validation must have a different value than field.
     *
     * @param string $anotherFiled Name of field to compare with
     * @return static
     */
    public function different(string $anotherFiled)
    {
        return $this->appendIfNotExists("different:$anotherFiled");
    }

    /**
     * The field under validation must have a minimum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     *
     * @param integer $minimalValue For numeric data, value corresponds to a given integer value.
     *                              For an array, size corresponds to the count of the array.
     *                              For string data, value corresponds to the number of characters.
     *                              For files, size corresponds to the file size in kilobytes.
     * @return static
     */
    public function min($minimalValue)
    {
        return $this->appendIfNotExists("min:$minimalValue");
    }

    /**
     * The field under validation must be less than or equal to a maximum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     *
     * @param integer $maximalValue For numeric data, value corresponds to a given integer value.
     *                              For an array, size corresponds to the count of the array.
     *                              For string data, value corresponds to the number of characters.
     *                              For files, size corresponds to the file size in kilobytes.
     * @return static
     */
    public function max($maximalValue)
    {
        return $this->appendIfNotExists("max:$maximalValue");
    }

    /**
     * The field under validation must have a size between the given min and max. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
     *
     * @param integer $minimalValue For numeric data, value corresponds to a given integer value.
     *                              For an array, size corresponds to the count of the array.
     *                              For string data, value corresponds to the number of characters.
     *                              For files, size corresponds to the file size in kilobytes.
     * @param integer $maximalValue For numeric data, value corresponds to a given integer value.
     *                              For an array, size corresponds to the count of the array.
     *                              For string data, value corresponds to the number of characters.
     *                              For files, size corresponds to the file size in kilobytes.
     * @return static
     */
    public function between($minimalValue, $maximalValue)
    {
        return $this->appendIfNotExists("between:$minimalValue,$maximalValue");
    }

    /**
     * The field under validation must have a size matching the given value.
     *
     * For string data, value corresponds to the number of characters.
     * For numeric data, value corresponds to a given integer value.
     * For an array, size corresponds to the count of the array.
     * For files, size corresponds to the file size in kilobytes.
     *
     * @param int $value Size value
     * @return static
     */
    public function size(int $value)
    {
        return $this->appendIfNotExists("size:$value");
    }

    /**
     * Run validation checks against a field only if that field is present in the input array.
     *
     * @return static
     */
    public function sometimes()
    {
        return $this->appendIfNotExists("sometimes");
    }

    /**
     * The field under validation must pass custom validation rule.
     *
     * @param string $customRule Custom rule name
     * @return GenericRuleSet
     * @throws ConfigurationException
     * @see https://laravel.com/docs/5.4/validation#custom-validation-rules
     * @see \Illuminate\Validation\Factory::extend
     */
    public function custom(string $customRule): GenericRuleSet
    {
        if (!Config::get('validation.allow_custom', false)) {
            throw new ConfigurationException("Custom validation rules are disabled. "
                . "To use custom validation rules, registered via Validator::extend, set configuration parameter "
                . "'validation.allow_custom' = true");
        }

        return $this->appendIfNotExists($customRule);
    }
}
