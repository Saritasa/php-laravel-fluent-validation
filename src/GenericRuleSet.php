<?php

namespace Saritasa\Laravel\Validation;

class GenericRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['int', 'numeric', 'string'];

    function int(): IntRuleSet
    {
        return new IntRuleSet($this->rules);
    }

    function numeric(): NumericRuleSet
    {
        return new NumericRuleSet($this->rules);
    }

    function string(): StringRuleSet
    {
        return new StringRuleSet($this->rules);
    }
}
