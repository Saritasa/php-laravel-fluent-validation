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
}
