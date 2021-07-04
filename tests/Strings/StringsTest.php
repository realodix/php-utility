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

    /**
     * @test
     * @dataProvider hasLowercaseProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function hasLowercase($expected, $actual)
    {
        $this->assertSame($expected, Str::hasLowercase($actual));
    }

    /**
     * @test
     * @dataProvider hasUppercaseProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function hasUppercase($expected, $actual)
    {
        $this->assertSame($expected, Str::hasUppercase($actual));
    }

    /** @test */
    public function lcfirst()
    {
        $str = 'ÑTËRNÂTIÔNÀLIZÆTIØN';
        $lcfirst = 'ñTËRNÂTIÔNÀLIZÆTIØN';

        $this->assertSame($lcfirst, Str::lcfirst($str));
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

public function testStrToWords()
    {
        $this->assertSame(['', 'iñt', ' ', 'ërn', ' ', 'I', ''], Str::strToWords('iñt ërn I'));
        $this->assertSame(['iñt', 'ërn', 'I'], Str::strToWords('iñt ërn I', '', true));
        $this->assertSame(['iñt', 'ërn'], Str::strToWords('iñt ërn I', '', false, 1));

        $this->assertSame(['', 'âti', "\n ", 'ônà', ''], Str::strToWords("âti\n ônà"));
        $this->assertSame(["\t\t"], Str::strToWords("\t\t", "\n"));
        $this->assertSame(['', "\t\t", ''], Str::strToWords("\t\t", "\t"));
        $this->assertSame(['', '中文空白', ' ', 'oöäü#s', ''], Str::strToWords('中文空白 oöäü#s', '#'));
        $this->assertSame(['', 'foo', ' ', 'oo', ' ', 'oöäü', '#', 's', ''], Str::strToWords('foo oo oöäü#s', ''));
        $this->assertSame([''], Str::strToWords(''));

        $testArray = [
            'Düsseldorf'                       => 'Düsseldorf',
            'Ã'                                => 'Ã',
            'foobar  || 😃'                    => 'foobar  || 😃',
            ' '                                => ' ',
            ''                                 => '',
            "\n"                               => "\n",
            'test'                             => 'test',
            'Here&#39;s some quoted text.'     => 'Here&#39;s some quoted text.',
            '&#39;'                            => '&#39;',
            "\u0063\u0061\u0074"               => 'cat',
            "\u0039&#39;\u0039"                => '9&#39;9',
            '&#35;&#8419;'                     => '&#35;&#8419;',
            "\xcf\x80"                         => 'π',
            '%ABREPRESENT%C9%BB. «REPRESENTÉ»' => '%ABREPRESENT%C9%BB. «REPRESENTÉ»',
            'éæ'                               => 'éæ',

            'ðñòó¡¡à±áâãäåæçèéêëì¡í¡îï¡¡¢£¤¥¦§¨©ª«¬­®¯ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß°±²³´µ¶•¸¹º»¼½¾¿' => 'ðñòó¡¡à±áâãäåæçèéêëì¡í¡îï¡¡¢£¤¥¦§¨©ª«¬­®¯ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß°±²³´µ¶•¸¹º»¼½¾¿',
        ];

        foreach ($testArray as $test => $unused) {
            $this->assertSame($test, \implode(Str::strToWords($test)), '');
        }

        /*
         * UTF8 Global Non Strict
         */
        $this->assertSame(['', 'iñt', ' ', 'ërn', ' ', 'I', ''], Str::strToWords('iñt ërn I'));
        $this->assertSame(['iñt', 'ërn', 'I'], Str::strToWords('iñt ërn I', '', true));
        $this->assertSame(['iñt', 'ërn'], Str::strToWords('iñt ërn I', '', false, 1));

        $this->assertSame(['', 'âti', "\n ", 'ônà', ''], Str::strToWords("âti\n ônà"));
        $this->assertSame(["\t\t"], Str::strToWords("\t\t", "\n"));
        $this->assertSame(['', "\t\t", ''], Str::strToWords("\t\t", "\t"));
        $this->assertSame(['', '中文空白', ' ', 'oöäü#s', ''], Str::strToWords('中文空白 oöäü#s', '#'));
        $this->assertSame(['', 'foo', ' ', 'oo', ' ', 'oöäü', '#', 's', ''], Str::strToWords('foo oo oöäü#s', ''));
        $this->assertSame([''], Str::strToWords(''));

        $testArray = [
            'Düsseldorf'                       => 'Düsseldorf',
            'Ã'                                => 'Ã',
            'foobar  || 😃'                   => 'foobar  || 😃',
            ' '                                => ' ',
            ''                                 => '',
            "\n"                               => "\n",
            'test'                             => 'test',
            'Here&#39;s some quoted text.'     => 'Here&#39;s some quoted text.',
            '&#39;'                            => '&#39;',
            "\u0063\u0061\u0074"               => 'cat',
            "\u0039&#39;\u0039"                => '9&#39;9',
            '&#35;&#8419;'                     => '&#35;&#8419;',
            "\xcf\x80"                         => 'π',
            '%ABREPRESENT%C9%BB. «REPRESENTÉ»' => '%ABREPRESENT%C9%BB. «REPRESENTÉ»',
            'éæ'                               => 'éæ',

            'ðñòó¡¡à±áâãäåæçèéêëì¡í¡îï¡¡¢£¤¥¦§¨©ª«¬­®¯ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß°±²³´µ¶•¸¹º»¼½¾¿' => 'ðñòó¡¡à±áâãäåæçèéêëì¡í¡îï¡¡¢£¤¥¦§¨©ª«¬­®¯ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞß°±²³´µ¶•¸¹º»¼½¾¿',
        ];

        foreach ($testArray as $test => $unused) {
            $this->assertSame($test, \implode(Str::strToWords($test)), '');
        }
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

    public function testUcfirstSpace()
    {
        $str = ' iñtërnâtiônàlizætiøn';
        $ucfirst = ' iñtërnâtiônàlizætiøn';
        $this->assertSame($ucfirst, Str::ucfirst($str));
    }

    public function testUcfirstUpper()
    {
        $str = 'Ñtërnâtiônàlizætiøn';
        $ucfirst = 'Ñtërnâtiônàlizætiøn';
        $this->assertSame($ucfirst, Str::ucfirst($str));
    }

    public function testEmptyString()
    {
        $str = '';
        $this->assertSame('', Str::ucfirst($str));
    }

    public function testOneChar()
    {
        $str = 'ñ';
        $ucfirst = 'Ñ';
        $this->assertSame($ucfirst, Str::ucfirst($str));
    }

    public function testLinefeed()
    {
        $str = "ñtërn\nâtiônàlizætiøn";
        $ucfirst = "Ñtërn\nâtiônàlizætiøn";
        $this->assertSame($ucfirst, Str::ucfirst($str));
    }

    public function testUcfirst()
    {
        $str = 'ñtërnâtiônàlizætiøn';
        $ucfirst = 'Ñtërnâtiônàlizætiøn';
        $this->assertSame($ucfirst, Str::ucfirst($str));

        // ---

        $this->assertSame('', Str::ucfirst(''));
        $this->assertSame('Ä', Str::ucfirst('ä'));
        $this->assertSame('Öäü', Str::ucfirst('Öäü'));
        $this->assertSame('Öäü', Str::ucfirst('öäü'));
        $this->assertSame('Κόσμε', Str::ucfirst('κόσμε'));
        $this->assertSame('ABC-ÖÄÜ-中文空白', Str::ucfirst('aBC-ÖÄÜ-中文空白'));
        $this->assertSame('Iñtërnâtiônàlizætiøn', Str::ucfirst('iñtërnâtiônàlizætiøn'));
        $this->assertSame('Ñtërnâtiônàlizætiøn', Str::ucfirst('ñtërnâtiônàlizætiøn'));
        $this->assertSame(' iñtërnâtiônàlizætiøn', Str::ucfirst(' iñtërnâtiônàlizætiøn'));
        $this->assertSame('Ñtërnâtiônàlizætiøn', Str::ucfirst('Ñtërnâtiônàlizætiøn'));
        $this->assertSame('ÑtërnâtiônàlizætIøN', Str::ucfirst('ñtërnâtiônàlizætIøN'));
        $this->assertSame('ÑtërnâtiônàlizætIøN test câse', Str::ucfirst('ñtërnâtiônàlizætIøN test câse'));
        $this->assertSame('', Str::ucfirst(''));
        $this->assertSame('Ñ', Str::ucfirst('ñ'));
        $this->assertSame("Ñtërn\nâtiônàlizætiøn", Str::ucfirst("ñtërn\nâtiônàlizætiøn"));
        $this->assertSame('Deja', Str::ucfirst('deja'));
        $this->assertSame('Σσς', Str::ucfirst('σσς'));
        $this->assertSame('DEJa', Str::ucfirst('dEJa'));
        $this->assertSame('ΣσΣ', Str::ucfirst('σσΣ'));

        // alias
        $this->assertSame('Öäü', Str::ucwords('öäü'));
    }
}
