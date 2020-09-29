<?php

namespace Realodix\Utils\Test\Urls;

use PHPUnit\Framework\TestCase;
use Realodix\Utils\Url;

class SanitizeTest extends TestCase
{
    /**
     * @test
     * @dataProvider sanitizeProvider
     */
    public function sanitize($expected, $actual)
    {
        $this->assertSame($expected, Url::sanitize($actual));
    }

    public function sanitizeProvider()
    {
        return [
            ['laravel.com', 'laravel.com'],
            ['laravel.com', 'www.laravel.com'],
            ['laravel.com', 'http://laravel.com'],
            ['laravel.com', 'http://www.laravel.com'],
            ['laravel.com', 'https://laravel.com'],
            ['laravel.com', 'https://www.laravel.com'],
            ['laravel.com', 'https://www.laravel.com/'],
            ['laravel.com/abc', 'https://www.laravel.com/abc'],
            ['laravel.com/abc', 'https://www.laravel.com/abc/'],
        ];
    }
}
