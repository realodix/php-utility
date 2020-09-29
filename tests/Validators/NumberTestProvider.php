<?php

namespace Realodix\Utils\Test\Validators;

trait NumberTestProvider
{
    public function divisibleByProvider()
    {
        return [
            [-7, 1],
            [0, 3.1415],
            [42, 42],
            [42, 21],
            [3.25, 0.25],
            ['100', '10'],
            [4.1, 0.1],
            [-4.1, 0.1],
        ];
    }

    public function divisibleByInvalidProvider()
    {
        return [
            [3, 2],
            [3, -2],
            ['22', '"22"'],
        ];
    }
}
