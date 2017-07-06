<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
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

    /**
     * If same rule applied repeatedly, result should contain only one instance
     */
    public function testDoNotRepeat()
    {
        $this->assertEquals('required', Rule::required()->required()->required()->toString());
        $this->assertEquals('required|string', Rule::required()->string()->required()->required()->toString());
        $this->assertEquals('string|required', Rule::string()->required()->required()->required()->toString());
    }
}
