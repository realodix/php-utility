<?php

namespace Realodix\Utils\Test\Numbers;

use Realodix\Utils\Number\Iban;
use Realodix\Utils\Test\TestCase;

class IbanTest extends TestCase
{
    use IbanTestProvider;

    /**
     * @test
     * @dataProvider verifyProvider
     *
     * @param mixed $value
     */
    public function verify($value)
    {
        $this->assertTrue(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithInvalidFormatProvider
     *
     * @param mixed $value
     */
    public function verifyWithInvalidFormat($value)
    {
        $this->assertFalse(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithValidFormatButIncorrectChecksumProvider
     *
     * @param mixed $value
     */
    public function verifyWithValidFormatButIncorrectChecksum($value)
    {
        $this->assertFalse(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithUnsupportedCountryCodeProvider
     *
     * @param mixed $unsupportedCountryCode
     */
    public function verifyWithUnsupportedCountryCode($unsupportedCountryCode)
    {
        $this->assertFalse(Iban::verify($unsupportedCountryCode.'260211000000230064016'));
    }

    /**
     * @test
     * @dataProvider verifyWithInvalidCountryCodeProvider
     *
     * @param mixed $invalidCountryCode
     */
    public function verifyWithInvalidCountryCode($invalidCountryCode)
    {
        $this->assertFalse(Iban::verify($invalidCountryCode.'260211000000230064016'));
    }

    /**
     * @test
     * @dataProvider toHumanFormatProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function toHumanFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toHumanFormat($actual));
    }

    /**
     * @test
     * @dataProvider toObfuscatedFormatProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function toObfuscatedFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toObfuscatedFormat($actual));
    }

    /**
     * @test
     * @dataProvider toMachineFormatProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function toMachineFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toMachineFormat($actual));
    }

    /**
     * @test
     * @dataProvider getBbanProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function getBban($expected, $actual)
    {
        $this->assertSame($expected, Iban::getBban($actual));
    }

    /**
     * @test
     */
    public function getChecksum()
    {
        $this->assertSame('29', Iban::getChecksum('DE00 1001 0010 0987 6543 21'));
    }

    /**
     * @test
     */
    public function setChecksum()
    {
        $this->assertSame('DE29100100100987654321', Iban::setChecksum('DE00 1001 0010 0987 6543 21'));
    }
}
