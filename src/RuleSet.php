<?php

namespace Saritasa\Laravel\Validation;

class RuleSet
{
    /** @var array */
    protected $rules;

    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @return static
     */
    public function required()
    {
        return $this->appendIfNotExists('required');
    }

    public function requiredWith(string $otherField)
    {
        return $this->appendIfNotExists("required_with:$otherField");
    }

    public function requiredWithout(string $otherField)
    {
        return $this->appendIfNotExists("required_without:$otherField");
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

    public function toArray()
    {
        return array_map(function($rule) {
            if ($rule instanceof IRule) {
                return $rule->toString();
            } else {
                return $rule;
            }
        }, $this->rules);
    }

    public function toString()
    {
        return implode('|', $this->toArray());
    }
}
