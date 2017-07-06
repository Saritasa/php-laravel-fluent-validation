<?php

namespace Saritasa\Laravel\Validation;

use Saritasa\Exceptions\NotImplementedException;

/**
 * @method FileRuleSet dimensions(array $constraints) Get a dimensions constraint builder instance.
 * @method GenericRuleSet exists(string $table, string $column, \Closure $closure = null) Get a exists constraint builder instance.
 * @method GenericRuleSet unique(string $table, string $column, \Closure $closure = null) Get a unique constraint builder instance.
 */
class GenericRuleSet extends RuleSet
{
    const EXPOSED_RULES = ['int', 'numeric', 'string'];

    /**
     * The field under validation must be an integer.
     * @return IntRuleSet
     */
    function int(): IntRuleSet
    {
        return new IntRuleSet($this->rules);
    }

    /**
     * The field under validation must be numeric.
     * @return NumericRuleSet
     */
    function numeric(): NumericRuleSet
    {
        return new NumericRuleSet($this->rules);
    }

    /**
     * The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field.
     * @return StringRuleSet
     */
    function string(): StringRuleSet
    {
        return new StringRuleSet($this->rules);
    }

    /**
     * The field under validation must be a successfully uploaded file.
     * @return FileRuleSet
     */
    function file(): FileRuleSet
    {
        return new FileRuleSet($this->rules);
    }

    function __call($name, $arguments)
    {
        $ruleSet = null;
        if (in_array($name, StringRuleSet::EXPOSED_RULES)) {
            $ruleSet = new StringRuleSet($this->rules);
        } elseif (in_array($name, IntRuleSet::EXPOSED_RULES)) {
            $ruleSet = new IntRuleSet($this->rules);
        } elseif (in_array($name, DatabaseRuleSet::EXPOSED_RULES)) {
            $ruleSet = new DatabaseRuleSet($this->rules);
        } else {
            throw new NotImplementedException("Requested unknown rule $name");
        }
        return call_user_func_array([$ruleSet, $name], $arguments);
    }
}
