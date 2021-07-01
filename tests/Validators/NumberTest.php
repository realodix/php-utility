<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class NumberTest extends TestCase
{
    /** @test */
    public function fibonacci()
    {
        $this->assertTrue(Val::fibonacci(1));
        $this->assertTrue(Val::fibonacci(34));
        $this->assertFalse(Val::fibonacci('is_not_numeric'));
    }
}
