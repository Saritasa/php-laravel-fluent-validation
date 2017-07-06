<?php

namespace Saritasa\Laravel\Validation;

class RuleSet implements IRule
{
    const BASIC_RULES = [
        'in',
        'notIn',
        'required',
        'requiredIf',
        'requiredUnless',
        'requiredWith',
        'requiredWithAll',
        'requiredWithout',
        'requiredWithoutAll',
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
     * @return RuleSet
     */
    public function requiredWithout(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     * @param \string[] ...$otherFields
     * @return RuleSet
     */
    public function requiredWithoutAll(string ...$otherFields)
    {
        return $this->appendIfNotExists("required_without_all:".implode(',', $otherFields));
    }

    /**
     * The field under validation must be present and not empty if the anotherfield field is equal to any value.
     * @param string $anotherField
     * @param mixed $value
     * @return RuleSet
     */
    public function requiredIf(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_if:$anotherField,$value");
    }

    /**
     * The field under validation must be present and not empty unless the anotherfield field is equal to any value.
     * @param string $anotherField
     * @param mixed $value
     * @return RuleSet
     */
    public function requiredUnless(string $anotherField, $value)
    {
        return $this->appendIfNotExists("required_unless:$anotherField,$value");
    }


    /**
     * The field under validation must be included in the given list of values.
     * @param array ...$values
     * @return RuleSet
     */
    public function in(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::in($val));
    }

    /**
     * The field under validation must not be included in the given list of values.
     * @param array ...$values
     * @return RuleSet
     */
    public function notIn(...$values)
    {
        $val = count($values) == 1 ? $values[0] : $values;
        return $this->appendIfNotExists(\Illuminate\Validation\Rule::notIn($val));
    }

    /**
     * The field under validation must exist in anotherfield's values.
     * @param string $anotherFiled
     * @return RuleSet
     */
    public function inArray(string $anotherFiled)
    {
        return $this->appendIfNotExists("in_array:$anotherFiled");
    }




    protected function appendIfNotExists(string $rule)
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
        }, $this->rules);
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
