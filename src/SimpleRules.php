<?php

namespace Saritasa\Laravel\Validation;

/**
 * Just breakdown of RuleSet, containing too many methods for easy reading
 */
trait SimpleRules
{
    /**
     * The field under validation must exist in anotherfield's values.
     * @param string $anotherFiled
     * @return static
     */
    public function inArray(string $anotherFiled)
    {
        return $this->appendIfNotExists("in_array:$anotherFiled");
    }

    /**
     * The field under validation must be included in the given list of values.
     * @param array ...$values
     * @return static
     */
    public function in(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::in($val));
    }

    /**
     * The field under validation must not be included in the given list of values.
     * @param array ...$values
     * @return static
     */
    public function notIn(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::notIn($val));
    }

    /**
     * The given field must match the field under validation.
     * @param string $anotherField
     * @return static
     */
    public function same(string $anotherField)
    {
        return $this->appendIfNotExists("same:$anotherField");
    }

    /**
     * The field under validation must have a minimum value. Strings, numerics, arrays, and files are evaluated in the same fashion as the size rule.
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
     * @param int $value
     * @return static
     */
    public function size(int $value)
    {
        return $this->appendIfNotExists("size:$value");
    }
}