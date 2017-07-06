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
        $rules = Rule::string();
        $this->assertEquals('string', $rules->toString());
    }

    public function testInt()
    {
        $rules = Rule::int();
        $this->assertEquals('integer', $rules->toString());
    }

    public function testNumeric()
    {
        $rules = Rule::numeric();
        $this->assertEquals('numeric', $rules->toString());
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
