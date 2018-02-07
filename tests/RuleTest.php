<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Saritasa\Enums\Gender;
use Saritasa\Exceptions\NotImplementedException;
use Saritasa\Laravel\Validation\Rule;
use Saritasa\Laravel\Validation\RuleSet;
use UnexpectedValueException;

/**
 * Test basic features
 */
class RuleTest extends TestCase
{

    public function testString()
    {
        $this->assertEquals('string', Rule::string());
    }

    public function testInt()
    {
        $this->assertEquals('integer', Rule::int());
    }

    public function testNumeric()
    {
        $this->assertEquals('numeric', Rule::numeric());
    }

    public function testDate()
    {
        $this->assertEquals('date', Rule::date());
    }

    /**
     * For trivial rules camelCase method name is just converted to snake_case rule name
     */
    public function testTrivialRules()
    {
        foreach (RuleSet::TRIVIAL_RULES as $ruleName) {
            $this->assertEquals(Str::snake($ruleName), Rule::$ruleName());
        }
    }

    public function testSame()
    {
        $this->assertEquals('same:password_confirmation', Rule::same('password_confirmation'));
    }

    public function testSize()
    {
        $this->assertEquals('size:20', Rule::size(20));
    }

    public function testSometimes()
    {
        $this->assertEquals('sometimes', Rule::sometimes());
    }

    /**
     * Rule 'in' can accept values as list of parameters or as array
     */
    public function testIn()
    {
        $this->assertEquals('in:"male","female"', Rule::in('male', 'female'));
        $this->assertEquals('in:"Male","Female"', Rule::in(Gender::getConstants()));
    }

    /**
     * Rule 'notIn' can accept values as list of parameters or as array
     */
    public function testNotIn()
    {
        $this->assertEquals('not_in:"forbidden","deleted"', Rule::notIn('forbidden', 'deleted'));
        $this->assertEquals('not_in:"forbidden","deleted"', Rule::notIn(['forbidden', 'deleted']));
    }

    /**
     * Note, that argument for inArray rule - another input field name, not list of values (unlike 'in' rule)
     */
    public function testInArray()
    {
        $this->assertEquals('in_array:favorite_topics', Rule::inArray('favorite_topics'));
    }

    /**
     * If same rule applied repeatedly, result should contain only one instance
     */
    public function testDoNotRepeat()
    {
        $this->assertEquals('required', Rule::required()->required()->required()->toString());
        $this->assertEquals('required|string', Rule::required()->string()->required()->required()->toString());
        $this->assertEquals('string|required', Rule::string()->required()->required()->required()->toString());
    }

    public function testMixed()
    {
        $rules = Rule::string()->required()->min(3);
        $this->assertEquals('string|required|min:3', $rules);

        $this->assertEquals('string|email|nullable|present', Rule::email()->nullable()->present());

        $rules = Rule::requiredWithout('facebook_token')->confirmed();
        $this->assertEquals('required_without:facebook_token|confirmed', $rules);
    }


    /**
     * Requesting non-registered rule should throw "Not Implemented" exception
     */
    public function testNonExistent()
    {
        $this->expectException(NotImplementedException::class);
        Rule::nonExistent();
    }

    /**
     * Test that rule appended inside true callback of when() method.
     */
    public function testWhenTrueCallback()
    {
        $isPHPDeveloper = true;

        $salaryRule = Rule::int()->when($isPHPDeveloper,
            function(RuleSet $ruleWhenTrue) {
                return $ruleWhenTrue->min(1000000);
            },
            function(RuleSet $ruleWhenFalse) {
                return $ruleWhenFalse->max(1000);
            }
        );

        $this->assertEquals('integer|min:1000000', $salaryRule->toString());
    }

    /**
     * Test that rule appended inside false callback of when() method.
     */
    public function testWhenFalseCallback()
    {
        $rule = Rule::string()->when(
            false,
            function (RuleSet $rule) {
                return $rule->max(10); // Should not be executed as passed condition is false
            },
            function (RuleSet $rule) {
                return $rule->min(10); // Should be executed as passed condition if false
            }
        );

        $this->assertEquals('string|min:10', $rule->toString());
    }

    /**
     * Test that rule leaves the same when condition is false and false callback not passed to when() method.
     */
    public function testWhenFalseCallbackNotPassed()
    {
        $rule = Rule::string()->when(
            false,
            function (RuleSet $rule) {
                return $rule->max(10); // Should not be executed as passed condition is false
            }
        );

        $this->assertEquals('string', $rule->toString());
    }

    /**
     * Test that callback of when() method should return instance of RuleSet class.
     */
    public function testWhenUnexpectedResultInCallback()
    {
        $this->expectException(UnexpectedValueException::class);

        Rule::string()->when(true, function () {
            return 'min:10'; // Invalid value. Instance of RuleSet expected
        });
    }

    /**
     * Test that rule appended inside callback of when() method and inside of this callback.
     */
    public function testDeepWhenCallback()
    {
        $rule = Rule::string()
            ->when(true, function (RuleSet $rule) { // First level of condition
                return $rule->max(10)
                    ->when(true, function (RuleSet $rule) { // Second level of condition
                        return $rule->nullable();
                    });
            });

        $this->assertEquals('string|max:10|nullable', $rule->toString());
    }

    /**
     * Test that method when() works from static call of Rule class.
     */
    public function testWhenFromRuleClass()
    {
        $rule = Rule::when(true, function (RuleSet $rule) {
            return $rule->required()->max(10);
        });

        $this->assertEquals('required|max:10', $rule->toString());
    }

    /**
     * Test that method when() works in instance of DatabaseRuleSet class (not only from GenericRuleSet).
     */
    public function testWhenFromDatabaseRuleSetClass()
    {
        Config::shouldReceive('get')->with('validation.allow_db', false)->andReturn(true);

        $rule = Rule::exists('users', 'id')
            ->when(true, function (RuleSet $rule) {
                return $rule->nullable();
            });

        $this->assertEquals('exists:users,id|nullable', $rule->toString());

        Config::clearResolvedInstances();
    }
}
