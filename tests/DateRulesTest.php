<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class DateRulesTest extends TestCase
{
    function testDate()
    {
        $this->assertEquals('required|date', Rule::required()->date());
        $this->assertEquals('date|required', Rule::date()->required());
    }

    function testAfter()
    {
        $this->assertEquals('date|after:tomorrow', Rule::after('tomorrow'));
    }

    function testAfterOrEqual()
    {
        $this->assertEquals('date|after_or_equal:tomorrow', Rule::afterOrEqual('tomorrow'));
    }

    function testBefore()
    {
        $this->assertEquals('date|before:tomorrow', Rule::before('tomorrow'));
    }

    function testBeforeOrEqual()
    {
        $this->assertEquals('date|before_or_equal:tomorrow', Rule::beforeOrEqual('tomorrow'));
    }
}