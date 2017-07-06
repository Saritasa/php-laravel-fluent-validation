<?php

namespace Saritasa\Laravel\Validation;

use Saritasa\Exceptions\NotImplementedException;

/**
 * @method GenericRuleSet accepted()
 *
 */
class RuleSet implements IRule
{
    use RequiredRules, SimpleRules;

    const TRIVIAL_RULES = [
        'accepted',
        'alpha',
        'alphaDash',
        'alphaNum',
        'array',
        'boolean',
        'confirmed',
        'date',
        'distinct',
        'filled',
        'nullable',
        'present',
    ];

    const BASIC_RULES = [
        'in',
        'notIn',
        'nullable',
        'accepted',
        'confirmed',
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

    function __call($name, $arguments)
    {
        if (in_array($name, static::TRIVIAL_RULES)) {
            return $this->appendIfNotExists($name);
        } else {
            throw new NotImplementedException("Requested unknown rule $name");
        }
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
