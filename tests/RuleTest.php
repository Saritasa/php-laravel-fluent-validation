<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Saritasa\Enums\Gender;
use Saritasa\Laravel\Validation\Rule;
use Saritasa\Laravel\Validation\RuleSet;

/**
 * Test basic features
 */
class RuleTest extends TestCase
{

    public function testString()
    {
        $this->assertEquals('string', Rule::string());
    }

    public function testInt()
    {
        $this->assertEquals('integer', Rule::int());
    }

    public function testNumeric()
    {
        $this->assertEquals('numeric', Rule::numeric());
    }

    public function testDate()
    {
        $this->assertEquals('date', Rule::date());
    }

    /**
     * For trivial rules camelCase method name is just converted to snake_case rule name
     */
    public function testTrivialRules()
    {
        foreach (RuleSet::TRIVIAL_RULES as $ruleName) {
            $this->assertEquals(Str::snake($ruleName), Rule::$ruleName());
        }
    }

    public function testSame()
    {
        $this->assertEquals('same:password_confirmation', Rule::same('password_confirmation'));
    }

    public function testSize()
    {
        $this->assertEquals('size:20', Rule::size(20));
    }

    public function testSometimes()
    {
        $this->assertEquals('sometimes', Rule::sometimes());
    }

    /**
     * Rule 'in' can accept values as list of parameters or as array
     */
    public function testIn()
    {
        $this->assertEquals('in:male,female', Rule::in('male', 'female'));
        $this->assertEquals('in:Male,Female', Rule::in(Gender::getConstants()));
    }

    /**
     * Rule 'notIn' can accept values as list of parameters or as array
     */
    public function testNotIn()
    {
        $this->assertEquals('not_in:forbidden,deleted', Rule::notIn('forbidden', 'deleted'));
        $this->assertEquals('not_in:forbidden,deleted', Rule::notIn(['forbidden', 'deleted']));
    }

    /**
     * Note, that argument for inArray rule - another input field name, not list of values (unlike 'in' rule)
     */
    public function testInArray()
    {
        $this->assertEquals('in_array:favorite_topics', Rule::inArray('favorite_topics'));
    }

    /**
     * If same rule applied repeatedly, result should contain only one instance
     */
    public function testDoNotRepeat()
    {
        $this->assertEquals('required', Rule::required()->required()->required()->toString());
        $this->assertEquals('required|string', Rule::required()->string()->required()->required()->toString());
        $this->assertEquals('string|required', Rule::string()->required()->required()->required()->toString());
    }

    public function testMixed()
    {
        $rules = Rule::string()->required()->min(3);
        $this->assertEquals('string|required|min:3', $rules);

        $this->assertEquals('string|email|nullable|present',  Rule::email()->nullable()->present());

        $rules = Rule::requiredWithout('facebook_token')->confirmed();
        $this->assertEquals('required_without:facebook_token|confirmed',  $rules);
    }
}
