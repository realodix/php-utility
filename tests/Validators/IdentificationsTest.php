<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class IdentificationsTest extends TestCase
{
    use IdentificationsTestProvider;

    /**
     * @test
     * @dataProvider luhnProvider
     *
     * @param mixed $value
     */
    public function luhn($value)
    {
        $this->assertTrue(Val::luhn($value));
    }

    /**
     * @test
     * @dataProvider luhnInvalidProvider
     *
     * @param mixed $value
     */
    public function luhnInvalid($value)
    {
        $this->assertFalse(Val::luhn($value));
    }
}
