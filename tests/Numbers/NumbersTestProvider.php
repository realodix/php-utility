<?php

namespace Realodix\Utils\Test\Numbers;

use Realodix\Utils\Number\Number;

trait NumbersTestProvider
{
    public function formatProvider()
    {
        $value = '100100100';

        return [
            ['#100,100,100', $value, ['before' => '#']],
            ['100,100,100.000', $value, ['places' => 3]],
            ['100.100.100', $value, ['locale' => 'es_VE']],

            ['$0.0', 0.00001, ['places' => 1, 'before' => '$']],
            ['$-0.0', -0.00001, ['places' => 1, 'before' => '$']],
            ['1,23 €', 1.23, ['locale' => 'fr_FR', 'after' => ' €']],
        ];
    }

    public function formatDeltaProvider()
    {
        $value = '100100100';
        $testOptions = ['before' => '[', 'after' => ']'];
        $testOptions2 = ['places' => 1, 'before' => '[', 'after' => ']'];

        return [
            ['+100,100,100', $value, ['places' => 0]],
            ['+100,100,100', $value, ['before' => '', 'after' => '']],

            ['[+100,100,100]', $value, $testOptions],
            ['[-100,100,100]', -$value, $testOptions],

            ['[ -100,100,100 ]', -$value, ['before' => '[ ', 'after' => ' ]']],

            ['[0.0]', 0, $testOptions2],
            ['[0.0]', 0.0001, $testOptions2],

            ['+9.876,1', 9876.1234, ['places' => 1, 'locale' => 'de_DE']],
        ];
    }

    public function toAmountShortProvider()
    {
        return [
            ['12', 12],
            ['12', 12.3],

            ['1K', pow(10, 3)],
            ['10K', pow(10, 4)],
            ['100K', pow(10, 5)],
            ['12.34K+', 12345],

            ['1M', pow(10, 6)],
            ['10M', pow(10, 7)],
            ['100M', pow(10, 8)],
            ['99.99M+', 99997092],

            ['1B', pow(10, 9)],
            ['10B', pow(10, 10)],
            ['100B', pow(10, 11)],
            ['1.23B+', 1234567890],

            ['1T', pow(10, 12)],
            ['10T', pow(10, 13)],
            ['100T', pow(10, 14)],
            ['1.23T+', 1234567890000],
        ];
    }

    public function toPercentageProvider()
    {
        return [
            ['45%', 45, 0],
            ['45.00%', 45, 2],
            ['0%', 0, 0],
            ['0.0000%', 0, 4],
        ];
    }

    public function toPercentageWithOptionsProvider()
    {
        $options = ['multiply' => false];

        return [
            ['45%', 45, 0, $options],
            ['45.00%', 45, 2, $options],
            ['0%', 0, 0, $options],
            ['0.0000%', 0, 4, $options],

            ['46%', 0.456, 0, ['multiply' => true]],
            ['45.60%', 0.456, 2, ['multiply' => true]],
        ];
    }

    public function toPercentageFormatResultProvider()
    {
        $result = Number::toPercentage(0.456, 2, ['locale' => 'de-DE', 'multiply' => true]);
        $formatResult = str_replace("\xc2\xa0", ' ', $result);

        $result2 = Number::toPercentage(13, 0, ['locale' => 'fi_FI']);
        $formatResult2 = str_replace("\xc2\xa0", ' ', $result2);

        $result3 = Number::toPercentage(0.13, 0, ['locale' => 'fi_FI', 'multiply' => true]);
        $formatResult3 = str_replace("\xc2\xa0", ' ', $result3);

        return [
            ['45,60 %', $formatResult],
            ['13 %', $formatResult2],
            ['13 %', $formatResult3],
        ];
    }

    public function toSizeProvider()
    {
        return [
            ['0 Byte', 0],
            ['1 Byte', 1],
            ['45 Bytes', 45],
            ['1023 Bytes', 1023],
            ['1 kB', 1024],
            ['1.12 kB', 1024 + 123],
            ['512 kB', 1024 * 512],
            ['1 MB', pow(1024, 2) - 1],
            ['1.26 MB', 1321205.76],
            ['512.05 MB', 512.05 * pow(1024, 2)],
            ['1 GB', pow(1024, 3) - 1],
            ['512 GB', pow(1024, 3) * 512],
            ['1 TB', pow(1024, 4) - 1],
            ['512 TB', pow(1024, 4) * 512],
            ['1 PB', pow(1024, 5) - 1],
            ['1,024 YB', pow(1024, 9)],
            ['1,048,576 YB', pow(1024, 10)],
        ];
    }

    public function toRomanProvider()
    {
        return [
            ['XCVI', 96],
            ['MMDCCCXCV', 2895],
            ['CCCXXIX', 329],
            ['IV', 4],
            ['X', 10],
        ];
    }
}
