<?php

namespace Saritasa\Laravel\Validation;

class StringRuleSet extends RuleSet
{
    public function __construct(array $rules = [])
    {
        parent::__construct(self::mergeIfNotExists('string', $rules));
    }

    public function email(): StringRuleSet
    {
        return $this->appendIfNotExists('email');
    }

    public function regex(string $pattern){
        return $this->appendIfNotExists("regex:$pattern");
    }
}
