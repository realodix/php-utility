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
        $this->assertSame($expected, str($value1)->charAt($value2));
    }

    /** @test */
    public function limit()
    {
        $this->assertSame('Laravel is...', str('Laravel is a free, open source PHP web application framework.')->limit(10));
        $this->assertSame('这是一...', str('这是一段中文')->limit(6));

        $string = str('The PHP framework for web artisans.');
        $this->assertSame('The PHP...', $string->limit(7));
        $this->assertSame('The PHP', $string->limit(7, ''));
        $this->assertSame('The PHP framework for web artisans.', $string->limit(100));

        $nonAsciiString = str('这是一段中文');
        $this->assertSame('这是一...', $nonAsciiString->limit(6));
        $this->assertSame('这是一', $nonAsciiString->limit(6, ''));
    }

    /** @test */
    public function limitWord()
    {
        $str = 'Lorem ipsum dolor sit amet.';

        $this->assertSame('Lorem ipsum...', str($str)->limitWord(2));
        $this->assertSame('Lorem ipsum', str($str)->limitWord(2, ''));
        $this->assertSame('Hanster___', str('Hanster Realodix')->limitWord(1, '___'));
        $this->assertSame('Hanster Realodix', str('Hanster Realodix')->limitWord(3));
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
        $this->assertSame($expected, str($value)->stripTags());
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
        $this->assertSame($expected, str($value1)->slice($value2));
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
        $this->assertSame($expected, str($value1)->slice($value2, $value3));
    }
}
