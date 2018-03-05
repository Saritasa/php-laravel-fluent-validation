<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Validation\Validator;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Saritasa\Laravel\Validation\FluentValidationServiceProvider;
use Saritasa\Laravel\Validation\Rule;
use Saritasa\Laravel\Validation\Rules\NotPresent;

class NotPresentValidatorTest extends BaseTestCase
{
    protected $validator;

    /**
     * @param \Illuminate\Foundation\Application $application
     *
     * @return array
     */
    protected function getPackageProviders($application)
    {
        return [FluentValidationServiceProvider::class];
    }

    public function setUp()
    {
        parent::setUp();

        $this->validator = $this->app['validator'];
    }

    public function testNotPresentValid()
    {
        $result = $this->validator->make([
            'field' => null,
        ], [
            'field' => 'not_present',
        ])->passes();
        $this->assertTrue($result);
    }

    public function testNotPresentInvalid()
    {
        $result = $validator = $this->validator->make([
            'field' => 'something',
        ], [
            'field' => 'not_present',
        ])->passes();
        $this->assertFalse($result);
    }

    public function testNotPresentValidWithFluentWay()
    {
        $result = $this->validator->make([
            'field' => null,
        ], [
            'field' => Rule::notPresent(),
        ])->passes();
        $this->assertTrue($result);
    }

    public function testNotPresentInvalidWithFluentWay()
    {
        $result = $this->validator->make([
            'field' => 'something',
        ], [
            'field' => Rule::notPresent(),
        ])->passes();
        $this->assertFalse($result);
    }

    public function testNotPresentInvalidMessage()
    {
        /** @var Validator $validator */
        $validator = $this->validator->make([
            'abc' => 'something',
        ], [
            'abc' => 'not_present',
        ]);

        $validator->passes();
        $message = $validator->getMessageBag();
        $this->assertEquals(
            $message->get('abc')[0],
            trans('fluent_validation::validation.not_present', ['attribute' => 'abc'])
        );
    }

    public function testNotPresentInvalidWithNewValidation()
    {
        /** @var Validator $validator */
        $validator = $this->validator->make([
            'abc' => 'something',
        ], [
            'abc' => new NotPresent(),
        ]);
        $validator->passes();
        $message = $validator->getMessageBag();
        $this->assertEquals(
            $message->get('abc')[0],
            trans('fluent_validation::validation.not_present', ['attribute' => 'abc'])
        );
    }
}