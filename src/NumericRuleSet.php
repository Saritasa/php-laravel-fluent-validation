<?php

namespace Saritasa\Laravel\Validation;

/**
 * Rules, that are reasonable for numeric values only
 */
class NumericRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['digits', 'digitsBetween'];

    protected $primaryRuleName = 'numeric';

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists($this->primaryRuleName, $rules));
    }

    /**
     * The field under validation must be numeric and must have an exact length of value.
     * @return NumericRuleSet
     * @param int $length
     */
    public function digits($length): NumericRuleSet
    {
        return $this->appendIfNotExists("digits:$length");
    }

    /**
     * The field under validation must have a length between the given min and max.
     * @param $minLength
     * @param $maxLength
     * @return NumericRuleSet
     */
    public function digitsBetween($minLength, $maxLength): NumericRuleSet
    {
        return $this->appendIfNotExists("digits_between:$minLength,$maxLength");
    }
}
