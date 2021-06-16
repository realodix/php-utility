<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class InternetTest extends TestCase
{
    use InternetTestProvider;

    /**
     * @test
     * @dataProvider urlValidProvider
     */
    public function url($url)
    {
        $this->assertTrue(Val::url($url));
    }

    /**
     * @test
     * @dataProvider urlInvalidProvider
     */
    public function urlInvalid($url)
    {
        $this->assertFalse(Val::url($url));
    }
}
