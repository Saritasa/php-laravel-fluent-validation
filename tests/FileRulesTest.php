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
}
