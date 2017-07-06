<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;
use Saritasa\Laravel\Validation\StringRuleSet;

/**
 * Check string rules
 */
class StringRulesTest extends TestCase
{
    public function testFluidString()
    {
        $rules = Rule::required()->string()->email()->requiredWithout('facebook_id');
        $this->assertEquals('required|string|email|required_without:facebook_id', $rules);
    }

    public function testRegex()
    {
        $rules = Rule::string()->regex('/^\w+[\w-\.]*\w+$/');
        $this->assertEquals('string|regex:/^\w+[\w-\.]*\w+$/', $rules);
    }

    public function testTimezone()
    {
        $this->assertEquals('string|timezone', Rule::timezone());
    }

    public function testDoNotRepeat()
    {
        $rules = Rule::string()->email()->email()->regex('@mail.ru$')->regex('@mail.ru$')->email();
        $this->assertEquals('string|email|regex:/@mail.ru$/', $rules);
    }

    public function testTrivialRules()
    {
        foreach (StringRuleSet::TRIVIAL_STRING_RULES as $ruleName) {
            $this->assertEquals('string|'.$ruleName, Rule::$ruleName());
        }
    }
}
