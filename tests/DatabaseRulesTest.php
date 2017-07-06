<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
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

    /** Mock configuration value to allow DB validation
     * @param bool $allowed
     */
    protected function allowDbValidation(bool $allowed = true)
    {
        Config::shouldReceive('get')->with('validation.allow_db', false)->andReturn($allowed);
    }

    /**
     *  Do not allow to use DB validation rules, unless it is set explicitly in configuration
     */
    public function testConfigurationRequired()
    {
        $this->allowDbValidation(false);
        $this->expectException(ConfigurationException::class);

        Rule::exists('users', 'email');
    }


    /**
     * Basic form of Rule::exists('table', 'column') works.
     */
    public function testExists()
    {
        $this->allowDbValidation(true);

        $this->assertEquals('exists:users,email', Rule::exists('users', 'email'));
    }

    public function testExists2()
    {
        $this->allowDbValidation(true);

        $rules = Rule::required()->exists('users', 'email');
        $this->assertEquals('required|exists:users,email', $rules->toString());
    }

    /**
     * Extended form of Rule::exists('table', 'column', <Builder callback>) works,
     * Builder callback gets newly created rule as parameter
     * and final rule has all parameters, set in callback
     */
    public function testExistsWithBuilder()
    {
        $this->allowDbValidation(true);

        $rules = Rule::exists('users', 'email', function(Exists $rule) {
            $rule->whereNotNull('login')
                ->where('role', 'user')
                ->whereNull('activation_date')
                ->whereNot('blocked', true);
        })->required();
        $this->assertEquals('exists:users,email,login,NOT_NULL,role,user,activation_date,NULL,blocked,!1|required', $rules);
    }

    /**
     * Basic form of Rule::unique('table', 'column') works
     */
    public function testUnique()
    {
        $this->allowDbValidation(true);

        $this->assertEquals('unique:users,email', Rule::unique('users', 'email'));
    }

    /**
     * Extended form of Rule::unique('table', 'column', <Builder callback>) works,
     * Builder callback gets newly created rule as parameter
     * and final rule has all parameters, set in callback
     */
    public function testUniqueWithBuilder()
    {
        $this->allowDbValidation(true);

        $rules = Rule::unique('users', 'email', function (Unique $rule) {
            $rule->ignore(123) // Except current user ID, for example
                ->whereNull('deleted_at');
        })->requiredWithout('facebook_id');

        $this->assertEquals('unique:users,email,"123",id,deleted_at,NULL|required_without:facebook_id', $rules);
    }
}
