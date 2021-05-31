<?php

namespace Realodix\Utils\Test\Strings;

use PHPUnit\Framework\TestCase;
use Realodix\Utils\Str;

class StringsTest extends TestCase
{
    use StringsTestProvider;

    private $_long_string = 'Once upon a time, a PHP package had no tests. It sad. So some nice people began to write tests. The more time that went on, the happier it became. Everyone was happy.';

    /**
     * @test
     * @dataProvider charAtProvider
     */
    public function charAt($expected, $value1, $value2)
    {
        $this->assertSame($expected, str($value1)->charAt($value2));
    }

    /** @test */
    public function ellipsize()
    {
        $strs = [
            '0'  => [
                'this is my string'             => '&hellip; my string',
                "here's another one"            => '&hellip;nother one',
                'this one is just a bit longer' => '&hellip;bit longer',
                'short'                         => 'short',
            ],
            '.5' => [
                'this is my string'             => 'this &hellip;tring',
                "here's another one"            => "here'&hellip;r one",
                'this one is just a bit longer' => 'this &hellip;onger',
                'short'                         => 'short',
            ],
            '1'  => [
                'this is my string'             => 'this is my&hellip;',
                "here's another one"            => "here's ano&hellip;",
                'this one is just a bit longer' => 'this one i&hellip;',
                'short'                         => 'short',
            ],
        ];
        foreach ($strs as $pos => $s) {
            foreach ($s as $str => $expect) {
                $this->assertEquals($expect, str($str)->ellipsize(10, $pos));
            }
        }
    }

    /** @test */
    public function excerpt()
    {
        $string = $this->_long_string;
        $result = ' Once upon a time, a PHP package had no tests. It s d. So some nice people began to write tests. The more time that went on, the happier it became. ...';
        $this->assertEquals(str($string)->excerpt(), $result);
    }

    /** @test */
    public function excerptRadius()
    {
        $string = $this->_long_string;
        $phrase = 'began';
        $result = '... people began to ...';
        $this->assertEquals(str($string)->excerpt($phrase, 10), $result);
    }

    /** @test */
    public function incrementString()
    {
        $this->assertSame('my-test_1', Str::of('my-test')->incrementString());
        $this->assertSame('my-test-1', Str::of('my-test')->incrementString('-'));
        $this->assertSame('file_5', Str::of('file_4')->incrementString());
        $this->assertSame('file-5', Str::of('file-4')->incrementString('-'));
        $this->assertSame('file-1', Str::of('file')->incrementString('-', '1'));
        $this->assertSame('124', Str::of('123')->incrementString(''));
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

    /** @test */
    public function readingTime()
    {
        // 12 words 74 characters
        $shortSentences = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';

        // 371 words 2,245 characters
        $longSentences = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

        It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).

        Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of 'de Finibus Bonorum et Malorum' (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 'Lorem ipsum dolor sit amet..', comes from a line in section 1.10.32.

        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.";

        $this->assertSame(1.0, str($shortSentences)->readingTime());
        $this->assertSame(2.0, str($longSentences)->readingTime());
    }

    /**
     * @test
     * @dataProvider removeNonAlphaProvider
     */
    public function removeNonAlpha($expected, $value)
    {
        $this->assertSame($expected, str($value)->removeNonAlpha());
    }

    /**
     * @test
     * @dataProvider removeNonAlphaNumProvider
     */
    public function removeNonAlphaNum($expected, $value)
    {
        $this->assertSame($expected, str($value)->removeNonAlphaNum());
    }

    /**
     * @test
     * @dataProvider removeNonNumericProvider
     */
    public function removeNonNumeric($expected, $value)
    {
        $this->assertSame($expected, str($value)->removeNonNumeric());
    }

    /**
     * @test
     * @dataProvider sliceProvider
     */
    public function slice($expected, $value1, $value2)
    {
        $this->assertSame($expected, str($value1)->slice($value2));
    }

    /**
     * @test
     * @dataProvider sliceProvider2
     */
    public function slice2($expected, $value1, $value2, $value3)
    {
        $this->assertSame($expected, str($value1)->slice($value2, $value3));
    }

    /** @test */
    public function wordWrap()
    {
        $string = 'Here is a simple string of text that will help us demonstrate this function.';
        $expected = "Here is a simple string\nof text that will help us\ndemonstrate this\nfunction.";
        $this->assertEquals(substr_count(str($string)->wordWrap(25), "\n"), 3);
        $this->assertEquals($expected, str($string)->wordWrap(25));

        $string2 = "Here is a\nbroken up sentence\rspanning lines\r\nwoohoo!";
        $expected2 = "Here is a\nbroken up sentence\nspanning lines\nwoohoo!";
        $this->assertEquals(substr_count(str($string2)->wordWrap(25), "\n"), 3);
        $this->assertEquals($expected2, str($string2)->wordWrap(25));

        $string3 = "Here is another slightly longer\nbroken up sentence\rspanning lines\r\nwoohoo!";
        $expected3 = "Here is another slightly\nlonger\nbroken up sentence\nspanning lines\nwoohoo!";
        $this->assertEquals(substr_count(str($string3)->wordWrap(25), "\n"), 4);
        $this->assertEquals($expected3, str($string3)->wordWrap(25));
    }

    /** @test */
    public function wordWrapUnwrap()
    {
        $string = 'Here is a {unwrap}simple string of text{/unwrap} that will help us demonstrate this function.';
        $expected = "Here is a simple string of text\nthat will help us\ndemonstrate this\nfunction.";
        $this->assertEquals(substr_count(str($string)->wordWrap(25), "\n"), 3);
        $this->assertEquals($expected, str($string)->wordWrap(25));
    }

    /** @test */
    public function wordWrapLongWords()
    {
        // the really really long word will be split
        $string = 'Here is an unbelievable super-complicated and reallyreallyquiteextraordinarily sophisticated sentence.';
        $expected = "Here is an unbelievable\nsuper-complicated and\nreallyreallyquiteextraor\ndinarily\nsophisticated sentence.";
        $this->assertEquals($expected, str($string)->wordWrap(25));
    }

    /** @test */
    public function wordWrapURL()
    {
        // the really really long word will be split
        $string = 'Here is an unbelievable super-complicated and http://www.reallyreallyquiteextraordinarily.com sophisticated sentence.';
        $expected = "Here is an unbelievable\nsuper-complicated and\nhttp://www.reallyreallyquiteextraordinarily.com\nsophisticated sentence.";
        $this->assertEquals($expected, str($string)->wordWrap(25));
    }

    /** @test */
    public function wordWrapCharlim()
    {
        $string = 'Here is a longer string of text that will help us demonstrate the default charlim of this function.';
        $this->assertEquals(strpos(str($string)->wordWrap(), "\n"), 73);
    }

    /**
     * @test
     * @dataProvider noCaseProvider
     */
    public function noCase($expected, $actual)
    {
        $this->assertSame($expected, Str::noCase($actual));
    }

    /**
     * @test
     * @dataProvider camelCaseProvider
     */
    public function camelCase($expected, $actual)
    {
        $this->assertSame($expected, Str::camelCase($actual));
    }

    /**
     * @test
     * @dataProvider capitalCaseProvider
     */
    public function capitalCase($expected, $actual)
    {
        $this->assertSame($expected, Str::capitalCase($actual));
    }

    /**
     * @test
     * @dataProvider constantCaseProvider
     */
    public function constantCase($expected, $actual)
    {
        $this->assertSame($expected, Str::constantCase($actual));
    }

    /**
     * @test
     * @dataProvider dotCaseProvider
     */
    public function dotCase($expected, $actual)
    {
        $this->assertSame($expected, Str::of($actual)->dotCase());
    }

    /**
     * @test
     * @dataProvider headerCaseProvider
     */
    public function headerCase($expected, $actual)
    {
        $this->assertSame($expected, Str::headerCase($actual));
    }

    /**
     * @test
     * @dataProvider pascalCaseProvider
     */
    public function pascalCase($expected, $actual)
    {
        $this->assertSame($expected, Str::pascalCase($actual));
    }

    /**
     * @test
     * @dataProvider pathCaseProvider
     */
    public function pathCase($expected, $actual)
    {
        $this->assertSame($expected, Str::pathCase($actual));
    }

    /**
     * @test
     * @dataProvider sentenceCaseProvider
     */
    public function sentenceCase($expected, $actual)
    {
        $this->assertSame($expected, Str::sentenceCase($actual));
    }

    /**
     * @test
     * @dataProvider snakeCaseProvider
     */
    public function snakeCase($expected, $actual)
    {
        $this->assertSame($expected, Str::snakeCase($actual));
    }

    /**
     * @test
     * @dataProvider spinalCaseProvider
     */
    public function spinalCase($expected, $actual)
    {
        $this->assertSame($expected, Str::spinalCase($actual));
    }

    /**
     * @test
     * @dataProvider swapCaseProvider
     */
    public function swapCase($expected, $actual)
    {
        $this->assertSame($expected, Str::swapCase($actual));
    }

    /**
     * @test
     * @dataProvider titleCaseProvider
     */
    public function titleCase($actual, $expected)
    {
        $this->assertSame($expected, Str::titleCase($actual));
    }
}
