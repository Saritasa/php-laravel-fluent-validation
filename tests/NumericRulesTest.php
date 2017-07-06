<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class NumericRulesTest extends TestCase
{
    /** Min and Max rules work */
    function testMinMax()
    {
        $rules = Rule::int()->min(1)->max(10);
        $this->assertEquals('integer|min:1|max:10', $rules->toString());
    }

    function testBetween()
    {
        $this->assertEquals('between:1,10', Rule::between(1, 10));
    }

    function testDigits()
    {
        $this->assertEquals('numeric|digits:6', Rule::digits(6));
        $this->assertEquals('numeric|digits_between:5,10', Rule::digitsBetween(5,10));
    }
}
