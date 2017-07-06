<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class RequiredRulesTest extends TestCase
{
    public function testRequired()
    {
        $rules = Rule::required();
        $this->assertEquals('required', $rules);
    }

    public function testRequiredWith()
    {
        $rules = Rule::requiredWith('first_name');
        $this->assertEquals('required_with:first_name', $rules);
    }

    public function testRequiredWithout()
    {
        $rules = Rule::requiredWithout('display_name');
        $this->assertEquals('required_without:display_name', $rules);
    }

    public function testRequiredWithAll()
    {
        $rules = Rule::requiredWithAll('email', 'subscription');
        $this->assertEquals('required_with_all:email,subscription', $rules);
    }

    public function testRequiredWithoutAll()
    {
        $rules = Rule::requiredWithoutAll('display_name', 'nice_name');
        $this->assertEquals('required_without_all:display_name,nice_name', $rules);
    }

    public function testRequiredIf()
    {
        $rules = Rule::requiredIf('gender', 'female');
        $this->assertEquals('required_if:gender,female', $rules);
    }

    public function testRequiredUnless()
    {
        $rules = Rule::requiredUnless('gender', 'male');
        $this->assertEquals('required_unless:gender,male', $rules);
    }
}
