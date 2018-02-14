<?php

namespace Saritasa\Laravel\Validation;

use Saritasa\Exceptions\NotImplementedException;

/**
 * Rules, available in all rule sets - for all data types
 *
 * @method GenericRuleSet accepted() The field under validation must be yes, on, 1, or true. This is useful for validating "Terms of Service" acceptance.
 * @method GenericRuleSet array() The field under validation must be a PHP array.
 * @method GenericRuleSet boolean() The field under validation must be able to be cast as a boolean. Accepted input are true,  false, 1, 0, "1", and "0".
 * @method GenericRuleSet confirmed() The field under validation must have a matching field of foo_confirmation. For example, if the field under validation is password, a matching password_confirmation field must be present in the input.
 * @method GenericRuleSet distinct() When working with arrays, the field under validation must not have any duplicate values.
 * @method GenericRuleSet filled() The field under validation must not be empty when it is present.
 * @method GenericRuleSet nullable() The field under validation may be null. This is particularly useful when validating primitive such as strings and integers that can contain null values.
 * @method GenericRuleSet present() The field under validation must be present in the input data but can be empty.
 * @method GenericRuleSet modelExists(string $modelClass, \Closure $closure = null) Get a exists constraint builder instance by model class.
 */
class RuleSet implements IRule
{
    use RequiredRules, SimpleRules;

    const TRIVIAL_RULES = [
        'accepted', // TODO move from here
        'array',    // TODO move from here
        'boolean',  // TODO move from here
        'confirmed',// TODO move from here
        'distinct',
        'filled',
        'nullable',
        'present',
    ];

    const BASIC_RULES = [
        'in',
        'notIn',
        'inArray',

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
        'between',
        'size',
        'sometimes',
        'custom',
        'when',
    ];

    /**
     * Array of accumulated rules
     *
     * @var array
     */
    protected $rules;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * Instead of implementing lots of trivial methods, which just return constant rule,
     * proxy calls to method, that appends known string rules to current set.
     *
     * @param string $name Method name
     * @param array $arguments Arguments, that should be passed to method being invoked
     * @return static
     * @throws NotImplementedException if requested method is unknown
     */
    public function __call(string $name, array $arguments)
    {
        if (in_array($name, static::TRIVIAL_RULES)) {
            return $this->appendIfNotExists($name);
        } else {
            throw new NotImplementedException("Requested unknown rule $name");
        }
    }

    /**
     * Append rule to current set of rules, but only if it doesn't contain this rule yet.
     * Creates new immutable set of rules, if rule was added.
     *
     * @param string $rule Rule to add
     * @return $this|static
     */
    protected function appendIfNotExists($rule)
    {
        if (in_array($rule, $this->rules)) {
            return $this;
        } else {
            return new static(array_merge($this->rules, [$rule]));
        }
    }

    /**
     * Append rule to array, if it is not contained in array yet.
     * Original array remains intact, new one is returned on changes.
     *
     * @param string $rule Rule to add
     * @param array $rules Set of rules, to which rule from first argument should be appended
     * @return array
     */
    protected static function mergeIfNotExists(string $rule, array $rules = []): array
    {
        if (in_array($rule, $rules)) {
            return $rules;
        } else {
            return array_merge($rules, [$rule]);
        }
    }

    /**
     * Performs conditional building of rule set.
     *
     * @param mixed $condition Condition to check
     * @param \Closure $trueCallback Callback that will be called when condition is TRUE.
     * Receives current rule set value and should return instance of RuleSer class.
     * @param \Closure|null $falseCallback Callback that will be called when condition is FALSE.
     * Receives current rule set value and should return instance of RuleSer class.
     *
     * @return RuleSet
     */
    public function when($condition, \Closure $trueCallback, \Closure $falseCallback = null): RuleSet
    {
        if ((bool)$condition) {
            $result = $trueCallback($this);
        } elseif ($falseCallback !== null) {
            $result = $falseCallback($this);
        } else {
            $result = $this;
        }

        if (!is_a($result, RuleSet::class)) {
            throw new \UnexpectedValueException('Callback should return instance of [' . RuleSet::class . '] class');
        }

        return $result;
    }

    /** Return current rule set as array */
    public function toArray(): array
    {
        return array_map(function ($rule) {
            if ($rule instanceof IRule) {
                return (string)$rule;
            } else {
                return $rule;
            }
        }, array_filter($this->rules));
    }

    /** Create string representation for current set of rules */
    public function toString(): string
    {
        return implode('|', $this->toArray());
    }

    /** Create string representation for current set of rules */
    public function __toString(): string
    {
        return $this->toString();
    }
}
