<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Config\Repository;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Saritasa\Laravel\Validation\FluentValidationServiceProvider;
use Saritasa\Laravel\Validation\FluentValidatorFactory;
use Saritasa\Laravel\Validation\Rule;

class NotPresentValidatorTest extends BaseTestCase
{
    /**
     * Validator factory
     *
     * @var FluentValidatorFactory
     */
    protected $validator;

    protected function getPackageProviders($application)
    {
        return [
            FluentValidationServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'config' => Repository::class,
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->validator = $this->app['validator'];
    }

    public function testNotPresentValid()
    {
        $validator = $this->validator->make([], [
            'field' => 'not_present',
        ]);
        $result = $validator->passes();
        $this->assertTrue($result);
    }

    public function testNotPresentValidWithFluentWay()
    {
        $validator = $this->validator->make([], [
            'field' => Rule::notPresent(),
        ]);
        $result = $validator->passes();
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

    public function testNotPresentInvalidWithFluentWay()
    {
        $result = $this->validator->make([
            'field' => null,
        ], [
            'field' => Rule::notPresent(),
        ])->passes();
        $this->assertFalse($result);
    }

    public function testNotPresentInvalidMessage()
    {
        $validator = $this->validator->make([
            'abc' => 'test',
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
}