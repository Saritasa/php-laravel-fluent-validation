<?php

namespace Saritasa\Laravel\Validation;

class IntRuleSet extends RuleSet
{
    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('int', $rules));
    }

    public function min(int $minimalValue): IntRuleSet
    {
        return $this->appendIfNotExists("min:$minimalValue");
    }

    public function max(int $maximalValue): IntRuleSet
    {
        return $this->appendIfNotExists("max:$maximalValue");
    }
}
