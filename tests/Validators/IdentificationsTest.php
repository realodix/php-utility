<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class IdentificationsTest extends TestCase
{
    use IdentificationsTestProvider;

    /**
     * @test
     * @dataProvider issnProvider
     *
     * @param mixed $value
     */
    public function issn($value)
    {
        $this->assertTrue(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidProvider
     *
     * @param mixed $value
     */
    public function issnInvalid($value)
    {
        $this->assertFalse(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidWithOptionsProvider
     *
     * @param mixed $value
     * @param mixed $options
     */
    public function issnInvalidWithOptions($value, $options)
    {
        $this->assertFalse(Val::issn($value, $options));
    }

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
