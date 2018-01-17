<?php

namespace Saritasa\Laravel\Validation\Tests;

use libphonenumber\PhoneNumberType;
use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class PhoneRulesTest extends TestCase
{

    public function testBaseRule()
    {
        $this->assertEquals('string|phone', Rule::phone());
    }

    public function testAutoDetectNumber()
    {
        $this->assertEquals('string|phone:AUTO', Rule::phone()->detect());
    }

    public function testCountry()
    {
        $this->assertEquals('string|phone:US', Rule::phone()->country('US'));
        $this->assertEquals('string|phone:BE,US', Rule::phone()->country('BE', 'US'));
        $this->assertEquals('string|phone:BE,US', Rule::phone()->country(['BE', 'US']));
    }

    public function testType()
    {
        $this->assertEquals('string|phone:' . PhoneNumberType::MOBILE, Rule::phone()->type(PhoneNumberType::MOBILE));

        $expected = 'string|phone:' . PhoneNumberType::MOBILE . ',' . PhoneNumberType::FIXED_LINE;
        $this->assertEquals($expected, Rule::phone()->type(PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE));
        $this->assertEquals($expected, Rule::phone()->type([PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE]));
        $this->assertEquals($expected, Rule::phone()->mobile()->fixedLine());

        $expected = 'string|phone:' . PhoneNumberType::FIXED_LINE . ',' . PhoneNumberType::MOBILE;
        $this->assertEquals($expected, Rule::phone()->fixedLine()->mobile());
    }

    public function testLenient()
    {
        $this->assertEquals('string|phone:LENIENT', Rule::phone()->lenient());
    }

    public function testOptions()
    {
        $this->assertEquals(
            'string|phone:US,' . PhoneNumberType::MOBILE . ',AUTO,LENIENT',
            Rule::phone()->country('US')->mobile()->detect()->lenient()
        );

        $this->assertEquals(
            'string|phone:US,BE,' . PhoneNumberType::MOBILE . ',AUTO,LENIENT',
            Rule::phone()->country(['US', 'BE'])->mobile()->detect()->lenient()
        );

        $this->assertEquals(
            'string|phone:US,' . PhoneNumberType::MOBILE . ',' . PhoneNumberType::FIXED_LINE . ',AUTO,LENIENT',
            Rule::phone()->country('US')->mobile()->fixedLine()->detect()->lenient()
        );

        $this->assertEquals(
            'string|phone:AUTO,LENIENT',
            Rule::phone()->detect()->lenient()
        );
    }

    public function testWithOtherRules()
    {
        $this->assertEquals(
            'string|phone:AUTO,LENIENT|required',
            Rule::phone()->detect()->lenient()->required()
        );
        $this->assertEquals(
            'string|phone:AUTO|required|size:14',
            Rule::phone()->detect()->required()->size(14)
        );
    }
}
