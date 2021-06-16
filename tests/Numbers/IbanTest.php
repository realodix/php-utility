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
     */
    public function verify($value)
    {
        $this->assertTrue(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithInvalidFormatProvider
     */
    public function verifyWithInvalidFormat($value)
    {
        $this->assertFalse(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithValidFormatButIncorrectChecksumProvider
     */
    public function verifyWithValidFormatButIncorrectChecksum($value)
    {
        $this->assertFalse(Iban::verify($value));
    }

    /**
     * @test
     * @dataProvider verifyWithUnsupportedCountryCodeProvider
     */
    public function verifyWithUnsupportedCountryCode($unsupportedCountryCode)
    {
        $this->assertFalse(Iban::verify($unsupportedCountryCode.'260211000000230064016'));
    }

    /**
     * @test
     * @dataProvider verifyWithInvalidCountryCodeProvider
     */
    public function verifyWithInvalidCountryCode($invalidCountryCode)
    {
        $this->assertFalse(Iban::verify($invalidCountryCode.'260211000000230064016'));
    }

    /**
     * @test
     * @dataProvider toHumanFormatProvider
     */
    public function toHumanFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toHumanFormat($actual));
    }

    /**
     * @test
     * @dataProvider toObfuscatedFormatProvider
     */
    public function toObfuscatedFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toObfuscatedFormat($actual));
    }

    /**
     * @test
     * @dataProvider toMachineFormatProvider
     */
    public function toMachineFormat($expected, $actual)
    {
        $this->assertSame($expected, Iban::toMachineFormat($actual));
    }

    /**
     * @test
     * @dataProvider getBbanProvider
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
