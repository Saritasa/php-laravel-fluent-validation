<?php

namespace Saritasa\Laravel\Validation\Tests;

use PHPUnit\Framework\TestCase;
use Saritasa\Laravel\Validation\Rule;

class FileRulesTest extends TestCase
{
    public function testFile()
    {
        $this->assertEquals('file', (string)Rule::file());
    }

    public function minMaxFileSize()
    {
        $rules = Rule::file()->min(10)->max(1000);
        $this->assertEquals('file|min:10|max:1000', $rules);
    }

    public function testImageFile()
    {
        $rules = Rule::image()->file();
        $this->assertEquals('image|file', $rules->toString());
    }

    public function testMimes()
    {
        $rules = Rule::file()->mimes('png', 'jpg', 'svg');
        $this->assertEquals('file|mimes:png,jpg,svg', $rules);

        $rules = Rule::mimes('png', 'jpg', 'svg');
        $this->assertEquals('file|mimes:png,jpg,svg', $rules);

        $rules = Rule::required()->mimes('png', 'jpg', 'svg');
        $this->assertEquals('required|file|mimes:png,jpg,svg', $rules);
    }

    public function testMimetypes()
    {
        $rules = Rule::file()->mimetypes('video/avi', 'video/mpeg', 'video/quicktime');
        $this->assertEquals('file|mimetypes:video/avi,video/mpeg,video/quicktime', $rules);
    }
}
