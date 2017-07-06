<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

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

    public function testNullable()
    {
        $this->assertEquals('nullable', Rule::nullable());
    }

    public function testPresent()
    {
        $this->assertEquals('present', Rule::present());
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
