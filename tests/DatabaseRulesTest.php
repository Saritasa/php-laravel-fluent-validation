<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use PHPUnit\Framework\TestCase;
use Saritasa\Enums\Gender;
use Saritasa\Exceptions\ConfigurationException;
use Saritasa\Laravel\Validation\Rule;
use UnexpectedValueException;

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

    /*
     * Test modelExists rule.
     */
    public function testModelExists()
    {
        $this->allowDbValidation(true);
        $rules = Rule::modelExists(TestUserModel::class);
        $this->assertEquals('exists:users,user_id', $rules->toString());
    }

    /*
     * Test modelExists rule with passed callback.
     */
    public function testModelExistsWithBuilder()
    {
        $this->allowDbValidation(true);
        $rules = Rule::modelExists(TestUserModel::class, function (Exists $rule) {
            $rule->whereNull('avatar_url')->where('active', 1);
        });
        $this->assertEquals('exists:users,user_id,avatar_url,NULL,active,1', $rules->toString());
    }

    /*
     * Test that modelExists supports only model class names.
     */
    public function testModelExistsNotModel()
    {
        $this->allowDbValidation(true);
        $this->expectException(UnexpectedValueException::class);
        Rule::modelExists(Gender::class);
    }
}

/**
 * Test model class to check modelExists rule. Should not be used in code.
 */
class TestUserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
}