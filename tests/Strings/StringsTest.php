<?php

namespace Realodix\Utils\Test\Strings;

use Realodix\Utils\Str;
use Realodix\Utils\Test\TestCase;

class StringsTest extends TestCase
{
    use StringsTestProvider;

    /**
     * Testing private/protected PHP methods using the Reflection API.
     *
     * @param mixed  $object
     * @param string $method
     * @param array  $parameters
     * @return mixed
     * @throws \Exception
     */
    private function callMethod($object, string $method, array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * @test
     * @dataProvider charAtProvider
     */
    public function charAt($expected, $value1, $value2)
    {
        $this->assertSame($expected, str($value1)->charAt($value2));
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
    public function readTime()
    {
        $wpm = 265;
        $this->assertSame('less than a minute', str(str_repeat('word', 3))->readTime($wpm));
        $this->assertSame('1 min read', str(str_repeat('word ', $wpm))->readTime($wpm));
        $this->assertSame('3 min read', str(str_repeat('word ', $wpm * 3))->readTime($wpm));
    }

    /** @test */
    public function readTimeWithImage()
    {
        $faker = FakerFactory::create();
        $wpm = 265;
        $content =
        '
            <img src="url" alt="alternatetext">
            <img src="dinosaur.jpg">
        '.$faker->sentence($wpm * 2, false);

        $this->assertSame('3 min read', str($content)->readTime($wpm));
    }

    /** @test */
    public function readTimeImage()
    {
        $content = str_repeat('<img />', 5);
        $actual = $this->callMethod(new Str, 'readTimeImage', [$content]) * 60;
        // 12+11+10+9+8
        $this->assertSame(50.0, $actual);

        $content = str_repeat('<img />', 10);
        $actual = $this->callMethod(new Str, 'readTimeImage', [$content]) * 60;
        // 12+11+10+9+8+7+6+5+4+3
        $this->assertSame(75.0, $actual);

        $content = str_repeat('<img />', 12);
        $actual = $this->callMethod(new Str, 'readTimeImage', [$content]) * 60;
        // 75 + (3+3)
        $this->assertSame(81.0, $actual);
    }

    /** @test */
    public function readTimeImageCount()
    {
        $content =
        '
            <img src="url" alt="alternatetext">
            <img src="dinosaur.jpg">
            <img />
            <img>
        ';

        $this->assertSame(3, $this->callMethod(new Str, 'readTimeImageCount', [$content]));
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
     * @dataProvider stripTagsProvider
     */
    public function stripTags($expected, $value)
    {
        $this->assertSame($expected, str($value)->stripTags());
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

    /**
     * @test
     * @dataProvider noCaseProvider
     */
    public function noCase($expected, $actual)
    {
        $this->assertSame($expected, Str::noCase($actual));
    }

    /** @test */
    public function noCaseWithOpt()
    {
        $this->assertSame('camel#case', Str::noCase('camelCase', '#'));
        $this->assertSame('camel#case', Str::noCase('#camel Case#', '#'));
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
