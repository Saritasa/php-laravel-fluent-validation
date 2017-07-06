<?php

namespace Saritasa\Laravel\Validation\Tests;

use Illuminate\Validation\Rules\Dimensions;
use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class ImageRulesTest extends TestCase
{
    function testImage()
    {
        $this->assertEquals('image', (string)Rule::image());
    }

    function testImageConstraintsBuilder()
    {
        $rules = Rule::image(function(Dimensions $image) {
            $image->width(100)->height(100);
        });
        $this->assertEquals('image|dimensions:width=100,height=100', (string)$rules);
    }
}
