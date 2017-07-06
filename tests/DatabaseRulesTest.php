<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rules\Exists;
use PHPUnit\Framework\TestCase;
use Saritasa\Exceptions\ConfigurationException;
use Saritasa\Laravel\Validation\Rule;

class DatabaseRulesTest extends TestCase
{
    /**
     * Reset mocked configuration after each test
     */
    protected function tearDown()
    {
        Config::clearResolvedInstances();
    }

    /**
     *  Do not allow to use DB validation rules, unless it is set explicitly in configuration
     */
    public function testConfigurationRequired()
    {
        Config::shouldReceive('get')->with('validation.allow_db', false)->andReturn(false);
        $this->expectException(ConfigurationException::class);

        Rule::exists('users', 'email');
    }


    /**
     * Basic form of Rule::exists('table', 'column') works.
     */
    public function testExists()
    {
        Config::shouldReceive('get')->with('validation.allow_db', false)->andReturn(true);
        $rules = Rule::exists('users', 'email');
        $this->assertEquals('exists:users,email', (string)$rules);
    }

    /**
     * Extended form of Rule::exists('table', 'column', <Builder callback>) works,
     * Builder callback gets newly created rule as parameter
     * and final rule has all parameters, set in callback
     */
    public function testExistsWithBuilder()
    {
        Config::shouldReceive('get')->with('validation.allow_db', false)->andReturn(true);
        $rules = Rule::exists('users', 'email', function(Exists $rule) {
            $rule->whereNotNull('login')
                ->where('role', 'user')
                ->whereNull('activation_date')
                ->whereNot('blocked', true);
        })->required();
        $this->assertEquals('exists:users,email,login,NOT_NULL,role,user,activation_date,NULL,blocked,!1|required', (string)$rules);
    }
}
