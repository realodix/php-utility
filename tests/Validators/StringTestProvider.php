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
}
