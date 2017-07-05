<?php

namespace Saritasa\Laravel\Validation;

class GenericRuleSet extends RuleSet
{
    function int(): IntRuleSet
    {
        return new IntRuleSet($this->rules);
    }

    function string(): StringRuleSet
    {
        return new StringRuleSet($this->rules);
    }
}
