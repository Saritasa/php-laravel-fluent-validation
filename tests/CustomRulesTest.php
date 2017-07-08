<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;
use Saritasa\Exceptions\ConfigurationException;
use Saritasa\Laravel\Validation\Rule;

class CustomRulesTest extends TestCase
{
    /**
     * Reset mocked configuration after each test
     */
    protected function tearDown()
    {
        Config::clearResolvedInstances();
    }

    /** Mock configuration value to allow custom validation rules
     * @param bool $allowed
     */
    protected function allowCustomValidation(bool $allowed = true)
    {
        Config::shouldReceive('get')->with('validation.allow_custom', false)->andReturn($allowed);
    }

    /**
     *  Do not allow to use custom validation rules, unless it is set explicitly in configuration
     */
    public function testConfigurationRequired()
    {
        $this->allowCustomValidation(false);
        $this->expectException(ConfigurationException::class);

        Rule::custom('foo');
    }

    /**
     * Basic form of Rule::custom('foo') works.
     */
    public function testCustom()
    {
        $this->allowCustomValidation(true);

        $this->assertEquals('foo', Rule::custom('foo'));
    }
}
