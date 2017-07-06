<?php

namespace Saritasa\Laravel\Validation;

class RuleSet implements IRule
{
    const BASIC_RULES = [
        'in',
        'notIn',
        'nullable',
        'present',
        'required',
        'requiredIf',
        'requiredUnless',
        'requiredWith',
        'requiredWithAll',
        'requiredWithout',
        'requiredWithoutAll',
        'same',

        'min',
        'max',
        'size',
    ];

    /** @var array */
    protected $rules;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
    The field under validation must be present in the input data and not empty. A field is considered "empty" if one of the following conditions are true:

    The value is null.
    The value is an empty string.
    The value is an empty array or empty Countable object.
    The value is an uploaded file with no path.

     * @return static
     */
    public function required()
    {
        return $this->appendIfNotExists('required');
    }

    /**
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     * @param \string[] $otherFields
     * @return static
     */
    public function requiredWith(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_with:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     * @param \string[] ...$otherFields
     * @return static
     */
    public function requiredWithAll(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_with_all:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only when any of the other specified fields are not present.
     * @param \string[] ...$otherFields
     * @return static
     */
    public function requiredWithout(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     * @param \string[] ...$otherFields
     * @return static
     */
    public function requiredWithoutAll(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without_all:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty if the anotherfield field is equal to any value.
     * @param string $anotherField
     * @param mixed $value
     * @return static
     */
    public function requiredIf(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_if:$anotherField,$value");
    }

    /**
     * The field under validation must be present and not empty unless the anotherfield field is equal to any value.
     * @param string $anotherField
     * @param mixed $value
     * @return static
     */
    public function requiredUnless(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_unless:$anotherField,$value");
    }

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
     * The field under validation may be null. This is particularly useful when validating primitive such as strings and integers that can contain null values.
     * @return static
     */
    public function nullable()
    {
        return $this->appendIfNotExists('nullable');
    }

    /**
     * The field under validation must be present in the input data but can be empty.
     * @return static
     */
    public function present()
    {
        return $this->appendIfNotExists('present');
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
     * The field under validation must have a size matching the given value.
     * For string data, value corresponds to the number of characters.
     * For numeric data, value corresponds to a given integer value.
     * For an array, size corresponds to the count of the array.
     * For files, size corresponds to the file size in kilobytes.
     * @param int $value
     * @return static
     */
    public function size(int $value)
    {
        return $this->appendIfNotExists("size:$value");
    }


    /**
     * Append rule to current set of rules, but only if it doesn't contain this rule yet.
     *
     * @param string $rule
     * @return $this|static
     */
    protected function appendIfNotExists($rule)
    {
        if (in_array($rule, $this->rules)) {
            return $this;
        }
        else {
            return new static(array_merge($this->rules, [$rule]));
        }
    }

    protected static function mergeIfNotExists(string $rule, array $rules = []): array
    {
        if (in_array($rule, $rules)) {
            return $rules;
        }
        else {
            return array_merge($rules, [$rule]);
        }
    }

    public function toArray(): array
    {
        return array_map(function($rule) {
            if ($rule instanceof IRule) {
                return (string)$rule;
            } else {
                return $rule;
            }
        }, array_filter($this->rules));
    }

    public function toString(): string
    {
        return implode('|', $this->toArray());
    }

    function __toString(): string
    {
        return $this->toString();
    }
}
