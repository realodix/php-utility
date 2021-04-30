<?php

namespace Realodix\Utils\Test\Urls;

use PHPUnit\Framework\TestCase;
use Realodix\Utils\Url;

class DisplayTest extends TestCase
{
    /**
     * @test
     */
    public function display()
    {
        $this->assertSame(
            'https://example.com/abcde/',
            Url::display('https://example.com/abcde/')
        );

        $this->assertSame(
            'example.com/abcde',
            Url::display('https://example.com/abcde/', false)
        );

        $this->assertSame(
            'https://example.com',
            Url::display('https://example.com/')
        );
    }

    /**
     * Truncates the given string at the specified length
     *
     * @test
     */
    public function displayTruncatesTheGivenStringAtTheSpecifiedLength()
    {
        $this->assertEquals(
            21,
            strlen(Url::display('https://example.com/abcde', limit: 21))
        );

        $this->assertSame(
            'https://example.com/abcde...',
            Url::display('https://example.com/abcdefghij', limit: 28)
        );

        $this->assertSame(
            'https://example.com/abc...hij',
            Url::display('https://example.com/abcdefghij', limit: 29)
        );

        $this->assertSame(
            'https://example...',
            Url::display('https://example.com/abc', limit: 18)
        );
    }

    /**
     * Remove scheme and truncates
     *
     * @test
     */
    public function displayRemoveSchemeAndTruncates()
    {
        $this->assertEquals(
            17,
            strlen(Url::display('https://example.com/abcde', false, 21))
        );

        $this->assertSame(
            'example.com/abcde...',
            Url::display('https://example.com/abcdefghij', false, 20)
        );

        $this->assertSame(
            'example.com/abc...hij',
            Url::display('https://example.com/abcdefghij', false, 21)
        );

        $this->assertSame(
            'example...',
            Url::display('https://example.com/abc', false, 10)
        );
    }
}
