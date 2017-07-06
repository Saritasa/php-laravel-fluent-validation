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
        $this->assertEquals('image|dimensions:width=100,height=100', $rules);
    }

    function testImageConstraintsFluent()
    {
        $rules = Rule::image(['ratio' => '1'])
            ->minWidth(25)->minHeight(25)
            ->maxWidth(500)->maxHeight(500);
        $this->assertEquals('image|dimensions:ratio=1,min_width=25,min_height=25,max_width=500,max_height=500', $rules);
    }
}
