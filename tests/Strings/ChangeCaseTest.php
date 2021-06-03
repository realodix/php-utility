<?php

namespace Realodix\Utils\Test\Strings;

use Realodix\Utils\String\ChangeCase;
use Realodix\Utils\Test\TestCase;

class ChangeCaseTest extends TestCase
{
    use ChangeCaseTestProvider;

    /**
     * @test
     * @dataProvider noCaseProvider
     */
    public function noCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->noCase($actual));
    }

    /** @test */
    public function noCaseWithOpt()
    {
        $this->assertSame('camel#case', (new ChangeCase)->noCase('camelCase', '#'));
        $this->assertSame('camel#case', (new ChangeCase)->noCase('#camel Case#', '#'));
    }

    /**
     * @test
     * @dataProvider camelCaseProvider
     */
    public function camelCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->camelCase($actual));
    }

    /**
     * @test
     * @dataProvider capitalCaseProvider
     */
    public function capitalCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->capitalCase($actual));
    }

    /**
     * @test
     * @dataProvider constantCaseProvider
     */
    public function constantCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->constantCase($actual));
    }

    /**
     * @test
     * @dataProvider dotCaseProvider
     */
    public function dotCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->dotCase($actual));
    }

    /**
     * @test
     * @dataProvider headerCaseProvider
     */
    public function headerCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->headerCase($actual));
    }

    /**
     * @test
     * @dataProvider pascalCaseProvider
     */
    public function pascalCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->pascalCase($actual));
    }

    /**
     * @test
     * @dataProvider pathCaseProvider
     */
    public function pathCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->pathCase($actual));
    }

    /**
     * @test
     * @dataProvider sentenceCaseProvider
     */
    public function sentenceCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->sentenceCase($actual));
    }

    /**
     * @test
     * @dataProvider snakeCaseProvider
     */
    public function snakeCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->snakeCase($actual));
    }

    /**
     * @test
     * @dataProvider spinalCaseProvider
     */
    public function spinalCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->spinalCase($actual));
    }

    /**
     * @test
     * @dataProvider swapCaseProvider
     */
    public function swapCase($expected, $actual)
    {
        $this->assertSame($expected, (new ChangeCase)->swapCase($actual));
    }

    /**
     * @test
     * @dataProvider titleCaseProvider
     */
    public function titleCase($actual, $expected)
    {
        $this->assertSame($expected, (new ChangeCase)->titleCase($actual));
    }
}
