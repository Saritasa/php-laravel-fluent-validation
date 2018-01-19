<?php

namespace Saritasa\Laravel\Validation;

use Saritasa\Laravel\Validation\Rules\Phone;

/**
 * Phone validation rule.
 * The rule has options: "country", "type", "detect", "lenient";
 *
 * @method PhoneRuleSet country($country) Set the country input field.
 * @method PhoneRuleSet countryField($name) Set the country input field.
 * @method PhoneRuleSet type($type) Set the phone types.
 * @method PhoneRuleSet mobile() Shortcut method for mobile type restriction.
 * @method PhoneRuleSet fixedLine() Shortcut method for fixed line type restriction.
 * @method PhoneRuleSet detect() Enable automatic country detection.
 * @method PhoneRuleSet lenient() Enable lenient number checking.
 *
 * @see https://github.com/Propaganistas/Laravel-Phone Documentation of Laravel Phone library.
 * @see \Propaganistas\LaravelPhone\Rules\Phone Rule of phone validation.
 *
 * @package Saritasa\Laravel\Validation
 */
class PhoneRuleSet extends StringRuleSet
{
    /**
     * Phone validation rule
     *
     * @var Phone
     */
    protected $rule;

    /**
     * PhoneRuleSet constructor.
     *
     * @param array $rules Set of rules to merge with
     */
    public function __construct(array $rules = [])
    {
        parent::__construct($rules);

        foreach ($this->rules as $rule) {
            if ($rule instanceof Phone) {
                $this->rule = $rule;
            }
        }

        if (!$this->rule) {
            $this->rule = new Phone();
            $this->rules[] = $this->rule;
        }
    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->rule, $name)) {
            call_user_func_array([$this->rule, $name], $arguments);
            return $this;
        }
        return parent::__call($name, $arguments);
    }
}
