<?php

namespace Realodix\Utils\Test\Numbers;

trait NumbersTestProvider
{
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

    public function toPercentageWithPrecisionProvider()
    {
        return [
            ['45%', 45, 0],
            ['45.00%', 45, 2],
            ['0%', 0, 0],
            ['0.0000%', 0, 4],
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
