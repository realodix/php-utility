<?php

namespace Realodix\Utils\Test\Strings;

use Realodix\Utils\Reflection;
use Realodix\Utils\Test\TestCase;

class ReflectionTest extends TestCase
{
    /** @test */
    public function reflectionOfMethod()
    {
        $this->assertSame('a', Reflection::method(new fooBar, 'abc'));
        $this->assertSame('a', Reflection::method(new fooBar, 'abcStatic'));
    }
}

class fooBar
{
    private function abc()
    {
        return 'a';
    }

    private static function abcStatic()
    {
        return 'a';
    }
}
