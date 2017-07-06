<?php

namespace Saritasa\Laravel\Validation;

class NumericRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['min', 'max'];
    protected $primaryRuleName = 'numeric';

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists($this->primaryRuleName, $rules));
    }

    public function min($minimalValue): NumericRuleSet
    {
        return $this->appendIfNotExists("min:$minimalValue");
    }

    public function max($maximalValue): NumericRuleSet
    {
        return $this->appendIfNotExists("max:$maximalValue");
    }
}
