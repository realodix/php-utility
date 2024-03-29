<?php

namespace Realodix\Utils\Test\Numbers;

use Realodix\Utils\Number\Number;
use Realodix\Utils\Test\TestCase;

class NumbersTest extends TestCase
{
    use NumbersTestProvider;

    /** @test */
    public function charToInt()
    {
        $this->assertSame('10 23 13', Number::charToInt('A 23 D'));
        $this->assertSame('10 23 45', Number::charToInt('A 23 d'));

        $this->assertSame('upper to int', Number::charToInt('upper to int', 1));
        $this->assertSame('30pper to 18nt', Number::charToInt('Upper to Int', 1));
        $this->assertSame('LOWER TO INT', Number::charToInt('LOWER TO INT', 2));
        $this->assertSame('L56644659 T56 I5561', Number::charToInt('Lower To Int', 2));

        $this->expectException(\Exception::class);
        Number::charToInt('A 23 D', 3);
        Number::charToInt('A 23 D', -1);
    }

    /** @test */
    public function mod97()
    {
        $this->assertSame(69, Number::mod97('100100100987654321131400'));
    }

    /** @test */
    public function precision()
    {
        $this->assertSame('19.12', Number::precision(19.123456));
        $this->assertSame('19.123', Number::precision(19.123456, 3));
    }

    /**
     * @test
     * @dataProvider toAmountShortProvider
     *
     * @param mixed $expected
     * @param mixed $actual
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

    /** @test */
    public function toPercentage()
    {
        $result = Number::toPercentage(45.691873645);
        $this->assertSame('45.69%', $result);
    }

    /**
     * @test
     * @dataProvider toPercentageWithPrecisionProvider
     *
     * @param mixed $expected
     * @param mixed $value
     * @param mixed $precision
     */
    public function toPercentageWithPrecision($expected, $value, $precision)
    {
        $this->assertSame($expected, Number::toPercentage($value, $precision));
    }

    /** @test */
    public function toPercentageWithOptions()
    {
        $result = Number::toPercentage(0.456, 0, true);
        $this->assertSame('46%', $result);

        $result = Number::toPercentage(0.456, 2, true);
        $this->assertSame('45.60%', $result);

        $result = Number::toPercentage(45.6, 2, false, 'de-DE');
        $this->assertSame('45,60%', $result);
    }

    /**
     * @test
     * @dataProvider toRomanProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function toRoman($expected, $actual)
    {
        $this->assertEquals($expected, Number::toRoman($actual));
    }

    /**
     * @test
     * @dataProvider toSizeProvider
     *
     * @param mixed $expected
     * @param mixed $actual
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
