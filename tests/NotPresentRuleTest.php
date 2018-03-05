<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class NotPresentTest extends TestCase
{
    /**
     * Test "not_present" rule
     */
    public function testNotPresent()
    {
        $this->assertEquals('not_present', Rule::notPresent());
    }

    /**
     * Test "not_present" rule with mixed usage
     */
    public function testMixedForNotPresent()
    {
        $rules = Rule::string()->notPresent()->min(3);
        $this->assertEquals('string|not_present|min:3', $rules);

        $this->assertEquals('string|email|nullable|not_present', Rule::email()->nullable()->notPresent());

    }
}
