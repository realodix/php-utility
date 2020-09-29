<?php

namespace Realodix\Utils\Test\Validators;

trait StringTestProvider
{
    public function hexRgbColorValidProvider()
    {
        return [
            ['#000'],
            ['#00000F'],
            ['#123'],
            ['#123456'],
            ['#FFFFFF'],
            ['123123'],
            ['FFFFFF'],
            [443],
        ];
    }

    public function hexRgbColorInvalidProvider()
    {
        return [
            ['#0'],
            ['#0000G0'],
            ['#0FG'],
            ['#1234'],
            ['#AAAAAA1'],
            ['#S'],
            ['1234'],
            ['foo'],
            [05],
            [1],
            [null],
        ];
    }

    public function startsWithValidProvider()
    {
        return [
            ['jason', 'jas'],
            ['jason', 'jason'],
            ['jason', ['jas']],
            ['jason', ['day', 'jas']],
            ['7a', '7'],
            ['7a', 7],
            ['7.12a', 7.12],
            [7.123, '7'],
            [7.123, '7.12'],
        ];
    }

    public function startsWithInvalidProvider()
    {
        return [
            ['jason', 'day'],
            ['jason', ['day']],
            ['jason', ''],
            ['7', ' 7'],
            ['7.12a', 7.13],
            [7.123, '7.13'],
        ];
    }

    public function endsWithValidProvider()
    {
        return [
            ['jason', 'on'],
            ['jason', 'jason'],
            ['jason', ['on']],
            ['jason', ['no', 'on']],
            ['a7', '7'],
            ['a7', 7],
            ['a7.12', 7.12],
            [0.27, '7'],
            [0.27, '0.27'],
        ];
    }

    public function endsWithInvalidProvider()
    {
        return [
            ['jason', 'no'],
            ['jason', ['no']],
            ['jason', ''],
            ['7', ' 7'],
            ['a7.12', 7.13],
            [0.27, '8'],
        ];
    }
}
