<?php

namespace Saritasa\Laravel\Validation;

class FileRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['min', 'max'];

    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('file', $rules));
    }

    public function dimensions(array $constraints): FileRuleSet
    {
        return new ImageRuleSet($constraints, $this->rules);
    }
}
