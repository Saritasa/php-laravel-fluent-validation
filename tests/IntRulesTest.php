<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class IntRulesTest extends TestCase
{
    function testMinMax()
    {
        $rules = Rule::int()->min(1)->max(10);
        $this->assertEquals('int|min:1|max:10', $rules->toString());
    }
}
