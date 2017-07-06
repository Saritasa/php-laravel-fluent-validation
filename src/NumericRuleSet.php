<?php

namespace Saritasa\Laravel\Validation;

/**
 * Rules, that are reasonable for numeric values only
 */
class NumericRuleSet extends RuleSet
{
    const EXPOSED_RULES = [];

    protected $primaryRuleName = 'numeric';

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists($this->primaryRuleName, $rules));
    }
}
