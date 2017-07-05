<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class RuleTest extends TestCase
{
    public function testRequired()
    {
        $rules = Rule::required();
        $this->assertEquals('required', $rules->toString());
    }

    public function testString()
    {
        $rules = Rule::string();
        $this->assertEquals('string', $rules->toString());
    }

    public function testInt()
    {
        $rules = Rule::int();
        $this->assertEquals('int', $rules->toString());
    }

    public function testDoNotRepeat()
    {
        $this->assertEquals('required', Rule::required()->required()->required()->toString());
        $this->assertEquals('required|string', Rule::required()->string()->required()->required()->toString());
        $this->assertEquals('string|required', Rule::string()->required()->required()->required()->toString());
    }
}
