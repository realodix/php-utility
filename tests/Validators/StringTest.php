<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class StringTest extends TestCase
{
    /** @test */
    public function containsAll()
    {
        $this->assertTrue(Val::containsAll('taylor otwell', ['taylor', 'otwell']));
        $this->assertTrue(Val::containsAll('taylor otwell', ['taylor']));
        $this->assertFalse(Val::containsAll('taylor otwell', ['taylor', 'xxx']));
    }
}
