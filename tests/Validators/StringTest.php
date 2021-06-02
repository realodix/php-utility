<?php

namespace Realodix\Utils\Test\Validators;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Realodix\Utils\Validator as Val;

class StringTest extends TestCase
{
    use StringTestProvider;

    /** @test */
    public function containsAll()
    {
        $this->assertTrue(Val::containsAll('taylor otwell', ['taylor', 'otwell']));
        $this->assertTrue(Val::containsAll('taylor otwell', ['taylor']));
        $this->assertFalse(Val::containsAll('taylor otwell', ['taylor', 'xxx']));
    }

    /**
     * @test
     * @dataProvider hexRgbColorValidProvider
     */
    public function hexRgbColor($value)
    {
        $this->assertTrue(Val::hexRgbColor($value));
    }

    /**
     * @test
     * @dataProvider hexRgbColorInvalidProvider
     */
    public function hexRgbColorInvalid($value)
    {
        $this->assertFalse(Val::hexRgbColor($value));
    }

    /** @test */
    public function list()
    {
        $this->assertFalse(Val::list(null));
        $this->assertTrue(Val::list([]));
        $this->assertTrue(Val::list([1]));
        $this->assertTrue(Val::list(['a', 'b', 'c']));
        $this->assertFalse(Val::list([4 => 1, 2, 3]));
        $this->assertFalse(Val::list([1 => 'a', 0 => 'b']));
        $this->assertFalse(Val::list(['key' => 'value']));

        $arr = [];
        $arr[] = &$arr;
        $this->assertTrue(Val::list($arr));
    }

    /** @test */
    public function range()
    {
        $this->assertTrue(Val::range(1, [0, 2]));
        $this->assertFalse(Val::range(-1, [0, 2]));
        $this->assertTrue(Val::range(-1, [-1, 1]));
        $this->assertTrue(Val::range(1, [-1, 1]));
        $this->assertTrue(Val::range(0.1, [-0.5, 0.5]));
        $this->assertFalse(Val::range(2, [-1, 1]));
        $this->assertFalse(Val::range(2.5, [-1, 1]));
    }

    /** @test */
    public function rangeAlpha()
    {
        $this->assertTrue(Val::range('a', ['a', 'z']));
        $this->assertFalse(Val::range('A', ['a', 'z']));

        $this->assertTrue(Val::range('', ['', '']));
        $this->assertTrue(Val::range('', ['', 'b']));
        $this->assertFalse(Val::range('', ['a', 'b']));
    }

    /** @test */
    public function rangeNull()
    {
        $this->assertTrue(Val::range(-1, [null, 2]));
        $this->assertTrue(Val::range(-1, ['', 2]));

        $this->assertTrue(Val::range(1, [-1, null]));
        $this->assertFalse(Val::range(1, [-1, '']));

        $this->assertFalse(Val::range(0, [null, null]));
        $this->assertFalse(Val::range('', [null, null]));
        $this->assertFalse(Val::range(10, [null, null]));

        $this->assertFalse(Val::range(null, [0, 1]));
        $this->assertFalse(Val::range(null, ['0', 'b']));

        $this->assertFalse(Val::range('', [0, 1]));
        $this->assertFalse(Val::range('a', [1, null]));
        $this->assertFalse(Val::range('a', [null, 9]));
        $this->assertTrue(Val::range('1', [null, 9]));
        $this->assertFalse(Val::range(10, ['a', null]));
        $this->assertTrue(Val::range(10, [null, 'a']));
    }

    /** @test */
    public function rangeDateTime()
    {
        $this->assertTrue(
            Val::range(
                new DateTimeImmutable('2017-04-26'),
                [new DateTime('2017-04-20'), new DateTime('2017-04-30')]
            )
        );
        $this->assertFalse(
            Val::range(
                new DateTimeImmutable('2017-04-26'),
                [new DateTime('2017-04-20'), new DateTime('2017-04-23')]
            )
        );

        $this->assertFalse(Val::range(new DateTimeImmutable('2017-04-26'), [10, null]));
        $this->assertFalse(Val::range(new DateTimeImmutable('2017-04-26'), [null, 10]));
    }

    /**
     * @test
     * @dataProvider startsWithValidProvider
     */
    public function startsWithValid($expected, $actual)
    {
        $this->assertTrue(Val::startsWith($expected, $actual));
    }

    /**
     * @test
     * @dataProvider startsWithInvalidProvider
     */
    public function startsWithInvalid($expected, $actual)
    {
        $this->assertFalse(Val::startsWith($expected, $actual));
    }

    /**
     * Test `startsWith()` for multibyte string support
     * @test
     */
    public function startsWithMultibyteString()
    {
        $this->assertTrue(Val::startsWith('Jönköping', 'Jö'));
        $this->assertTrue(Val::startsWith('Malmö', 'Malmö'));
        $this->assertFalse(Val::startsWith('Jönköping', 'Jonko'));
        $this->assertFalse(Val::startsWith('Malmö', 'Malmo'));
    }

    /**
     * @test
     * @dataProvider endsWithValidProvider
     */
    public function endsWithValid($expected, $actual)
    {
        $this->assertTrue(Val::endsWith($expected, $actual));
    }

    /**
     * @test
     * @dataProvider endsWithInvalidProvider
     */
    public function endsWithInvalid($expected, $actual)
    {
        $this->assertFalse(Val::endsWith($expected, $actual));
    }

    /**
     * Test `endsWith()` for multibyte string support
     * @test
     */
    public function endsWithMultibyteString()
    {
        $this->assertTrue(Val::endsWith('Jönköping', 'öping'));
        $this->assertTrue(Val::endsWith('Malmö', 'mö'));
        $this->assertFalse(Val::endsWith('Jönköping', 'oping'));
        $this->assertFalse(Val::endsWith('Malmö', 'mo'));
    }
}
