<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class NumberTest extends TestCase
{
    use NumberTestProvider;

    /**
     * @test
     * @dataProvider divisibleByProvider
     *
     * @param mixed $value1
     * @param mixed $value2
     */
    public function divisibleBy($value1, $value2)
    {
        $this->assertTrue(Val::divisibleBy($value1, $value2));
    }

    /**
     * @test
     * @dataProvider divisibleByInvalidProvider
     *
     * @param mixed $value1
     * @param mixed $value2
     */
    public function divisibleByInvalid($value1, $value2)
    {
        $this->assertFalse(Val::divisibleBy($value1, $value2));
    }

    /** @test */
    public function fibonacci()
    {
        $this->assertTrue(Val::fibonacci(1));
        $this->assertTrue(Val::fibonacci(34));
        $this->assertFalse(Val::fibonacci('is_not_numeric'));
    }

    /** @test */
    public function numeric()
    {
        $this->assertTrue(Val::numeric(23));
        $this->assertTrue(Val::numeric(1.78));
        $this->assertTrue(Val::numeric('+42'));
        $this->assertTrue(Val::numeric('3.14'));
        $this->assertFalse(Val::numeric('string'));
        $this->assertFalse(Val::numeric('1e6'));
    }

    /** @test */
    public function numericInt()
    {
        $this->assertTrue(Val::numericInt(23));
        $this->assertFalse(Val::numericInt(1.78));
        $this->assertTrue(Val::numericInt('+42'));
        $this->assertFalse(Val::numericInt('3.14'));
        $this->assertFalse(Val::numericInt('string'));
    }
}
