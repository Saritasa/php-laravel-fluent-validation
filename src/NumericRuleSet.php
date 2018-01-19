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
     *
     * @param int $length Expected number of digits
     * @return NumericRuleSet
     */
    public function digits(int $length): NumericRuleSet
    {
        return $this->appendIfNotExists("digits:$length");
    }

    /**
     * The field under validation must have a length between the given min and max.
     *
     * @param int $minLength Minimum number of digits
     * @param int $maxLength Maximum number of digits
     * @return NumericRuleSet
     */
    public function digitsBetween(int $minLength, int $maxLength): NumericRuleSet
    {
        return $this->appendIfNotExists("digits_between:$minLength,$maxLength");
    }
}
