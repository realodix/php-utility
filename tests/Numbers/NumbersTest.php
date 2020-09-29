<?php

namespace Realodix\Utils\Test\Numbers;

use PHPUnit\Framework\TestCase;
use Realodix\Utils\Number\Number;

class NumbersTest extends TestCase
{
    use NumbersTestProvider;

    /** @test */
    public function charToInt()
    {
        $this->assertSame('10 23 13', Number::charToInt('A 23 D'));
        $this->assertSame('10 23 45', Number::charToInt('A 23 d'));
    }

    /** @test */
    public function charUpperToInt()
    {
        $this->assertSame('10 23 d', Number::charUpperToInt('A 23 d'));
    }

    /** @test */
    public function charLowerToInt()
    {
        $this->assertSame('A 23 45', Number::charLowerToInt('A 23 d'));
    }

    /**
     * @test
     * @dataProvider formatProvider
     */
    public function format($expected, $value, $options)
    {
        $this->assertSame('100,100,100', Number::format('100100100'));
        $this->assertSame($expected, Number::format($value, $options));
    }

    /**
     * @test
     * @dataProvider formatDeltaProvider
     */
    public function formatDelta($expected, $value, $options)
    {
        $this->assertSame($expected, Number::formatDelta($value, $options));
    }

    /** @test */
    public function mod97()
    {
        $this->assertSame(69, Number::mod97('100100100987654321131400'));
    }

    /** @test */
    public function ordinal()
    {
        $this->assertSame('1st', Number::ordinal(1));
        $this->assertSame('2nd', Number::ordinal(2));
        $this->assertSame('3rd', Number::ordinal(3));
        $this->assertSame('4th', Number::ordinal(4));

        $options = ['locale' => 'id_ID'];
        $this->assertSame('ke-1', Number::ordinal(1, $options));
        $this->assertSame('ke-2', Number::ordinal(2, $options));

        $options = ['locale' => 'fr_FR'];
        $this->assertSame('1er', Number::ordinal(1, $options));
        $this->assertSame('2e', Number::ordinal(2, $options));
    }

    /** @test */
    public function precision()
    {
        $this->assertSame('1,234', Number::precision(1.234, 3, ['locale' => 'id_ID']));
        $this->assertSame('19.12', Number::precision(19.123456));
        $this->assertSame('19.123', Number::precision(19.123456, 3));
    }

    /**
     * @test
     * @dataProvider toAmountProvider
     */
    public function toAmount($expected, $actual, $opt)
    {
        $this->assertEquals($expected, Number::toAmount($actual, $opt));
    }

    /**
     * @test
     * @dataProvider toAmountShortProvider
     */
    public function toAmountShort($expected, $actual)
    {
        $this->assertSame($expected, Number::toAmountShort($actual));

        $intOrString = Number::toAmountShort($actual);

        if (is_int($intOrString)) {
            $this->assertIsInt($intOrString);
        } else {
            $this->assertIsString($intOrString);
        }
    }

    /**
     * @test
     * @dataProvider toPercentageProvider
     */
    public function toPercentage($expected, $value, $precision)
    {
        $this->assertSame($expected, Number::toPercentage($value, $precision));
    }

    /**
     * @test
     * @dataProvider toPercentageWithOptionsProvider
     */
    public function toPercentageWithOptions($expected, $value, $precision, $options)
    {
        $this->assertSame($expected, Number::toPercentage($value, $precision, $options));

        $result = Number::toPercentage(0.456, 2, ['locale' => 'de-DE', 'multiply' => true]);
        $formatResult = str_replace("\xc2\xa0", ' ', $result);
        $this->assertSame('45,60 %', $formatResult);

        $result = Number::toPercentage(13, 0, ['locale' => 'fi_FI']);
        $formatResult = str_replace("\xc2\xa0", ' ', $result);
        $this->assertSame('13 %', $formatResult);

        $result = Number::toPercentage(0.13, 0, ['locale' => 'fi_FI', 'multiply' => true]);
        $formatResult = str_replace("\xc2\xa0", ' ', $result);
        $this->assertSame('13 %', $formatResult);
    }

    /**
     * @test
     * @dataProvider toPercentageFormatResultProvider
     */
    public function toPercentageFormatResult($expected, $actual)
    {
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @dataProvider toRomanProvider
     */
    public function toRoman($expected, $actual)
    {
        $this->assertEquals($expected, Number::toRoman($actual));
    }

    /**
     * @test
     * @dataProvider toSizeProvider
     */
    public function toSize($expected, $actual)
    {
        $this->assertSame($expected, Number::toSize($actual));
    }

    /** @test */
    public function toSize2()
    {
        $mb = pow(1024, 2);

        $this->assertSame('1.33 MB', Number::toSize($mb + ($mb / 3)));
        $this->assertSame('1.3333 MB', Number::toSize($mb + ($mb / 3), 4));
    }

    /** @test */
    public function numbPrec()
    {
        $this->assertSame(19.12, Number::numbPrec(19.123456));
        $this->assertSame(19.123, Number::numbPrec(19.123456, 3));
    }
}
