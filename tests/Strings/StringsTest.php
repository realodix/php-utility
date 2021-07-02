<?php

namespace Realodix\Utils\Test\Strings;

use Realodix\Utils\Str;
use Realodix\Utils\Test\TestCase;

class StringsTest extends TestCase
{
    use StringsTestProvider;

    /**
     * @test
     * @dataProvider charAtProvider
     *
     * @param mixed $expected
     * @param mixed $value1
     * @param mixed $value2
     */
    public function charAt($expected, $value1, $value2)
    {
        $this->assertSame($expected, Str::charAt($value1, $value2));
    }

    /** @test */
    public function limit()
    {
        $this->assertSame('Laravel is...', Str::limit('Laravel is a free, open source PHP web application framework.', 10));
        $this->assertSame('这是一...', Str::limit('这是一段中文', 6));

        $string = 'The PHP framework for web artisans.';
        $this->assertSame('The PHP...', Str::limit($string, 7));
        $this->assertSame('The PHP', Str::limit($string, 7, ''));
        $this->assertSame('The PHP framework for web artisans.', Str::limit($string, 100));

        $nonAscii = '这是一段中文';
        $this->assertSame('这是一...', Str::limit($nonAscii, 6));
        $this->assertSame('这是一', Str::limit($nonAscii, 6, ''));
    }

    /** @test */
    public function limitWord()
    {
        $str = 'Lorem ipsum dolor sit amet.';

        $this->assertSame('Lorem ipsum...', Str::limitWord($str, 2));
        $this->assertSame('Lorem ipsum', Str::limitWord($str, 2, ''));
        $this->assertSame('Hanster___', Str::limitWord('Hanster Realodix', 1, '___'));
        $this->assertSame('Hanster Realodix', Str::limitWord('Hanster Realodix', 3));
    }

    /**
     * @test
     * @dataProvider stripTagsProvider
     *
     * @param mixed $expected
     * @param mixed $value
     */
    public function stripTags($expected, $value)
    {
        $this->assertSame($expected, Str::stripTags($value));
    }

    /**
     * @test
     * @dataProvider sliceProvider
     *
     * @param mixed $expected
     * @param mixed $value1
     * @param mixed $value2
     */
    public function slice($expected, $value1, $value2)
    {
        $this->assertSame($expected, Str::slice($value1, $value2));
    }

    /**
     * @test
     * @dataProvider sliceProvider2
     *
     * @param mixed $expected
     * @param mixed $value1
     * @param mixed $value2
     * @param mixed $value3
     */
    public function slice2($expected, $value1, $value2, $value3)
    {
        $this->assertSame($expected, Str::slice($value1, $value2, $value3));
    }
}
