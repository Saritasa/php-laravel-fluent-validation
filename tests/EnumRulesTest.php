<?php

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

/**
 * Check Enum rules
 * @see https://github.com/Saritasa/php-common#enum
 */
class EnumRulesTest extends TestCase
{
    /**
     * Basic usage
     */
    public function testEnum()
    {
        $rules = Rule::enum(\Saritasa\Enums\Gender::class)->toString();
        $this->assertEquals('string|in:"Male","Female"', $rules);
    }

    public function testNonExistingEnum()
    {
        $this->expectException(\UnexpectedValueException::class);
        Rule::enum("bullshit");
    }
}
