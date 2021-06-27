<?php

namespace Realodix\Utils\Test\Validators;

use Realodix\Utils\Test\TestCase;
use Realodix\Utils\Validator as Val;

class IdentificationsTest extends TestCase
{
    use IdentificationsTestProvider;

    /**
     * @test
     * @dataProvider creditCardProvider
     *
     * @param mixed $creditCard
     * @param mixed $cardNumber
     */
    public function creditCard($creditCard, $cardNumber)
    {
        $this->assertTrue(Val::creditCard($cardNumber, $creditCard));
    }

    /**
     * @test
     * @dataProvider creditCardInvalidProvider
     *
     * @param mixed $creditCard
     * @param mixed $cardNumber
     */
    public function creditCardInvalid($creditCard, $cardNumber)
    {
        $this->assertFalse(Val::creditCard($cardNumber, $creditCard));
    }

    /**
     * @test
     * @dataProvider isbn10Provider
     *
     * @param mixed $value
     */
    public function isbn($value)
    {
        $this->assertTrue(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn10InvalidProvider
     *
     * @param mixed $value
     */
    public function isbnInvalid($value)
    {
        $this->assertFalse(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn13Provider
     *
     * @param mixed $value
     */
    public function isbn13($value)
    {
        $this->assertTrue(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn13InvalidProvider
     *
     * @param mixed $value
     */
    public function isbn13Invalid($value)
    {
        $this->assertFalse(Val::isbn($value));
    }

    /** @test */
    public function isbnIs10()
    {
        $this->assertTrue(Val::isbnIs10('0545162076'));
        $this->assertFalse(Val::isbnIs10('9780545162074'));
    }

    /** @test */
    public function isbnIs13()
    {
        $this->assertTrue(Val::isbnIs13('9780545162074'));
        $this->assertFalse(Val::isbnIs13('0545162076'));
    }

    /**
     * @test
     * @dataProvider issnProvider
     *
     * @param mixed $value
     */
    public function issn($value)
    {
        $this->assertTrue(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidProvider
     *
     * @param mixed $value
     */
    public function issnInvalid($value)
    {
        $this->assertFalse(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidWithOptionsProvider
     *
     * @param mixed $value
     * @param mixed $options
     */
    public function issnInvalidWithOptions($value, $options)
    {
        $this->assertFalse(Val::issn($value, $options));
    }

    /**
     * @test
     * @dataProvider luhnProvider
     *
     * @param mixed $value
     */
    public function luhn($value)
    {
        $this->assertTrue(Val::luhn($value));
    }

    /**
     * @test
     * @dataProvider luhnInvalidProvider
     *
     * @param mixed $value
     */
    public function luhnInvalid($value)
    {
        $this->assertFalse(Val::luhn($value));
    }

    /**
     * @test
     * @dataProvider uuidProvider
     *
     * @param string $value
     * @param bool   $expected
     */
    public function uuid(string $value, bool $expected): void
    {
        $variations = [];
        $variations[] = $value;
        $variations[] = 'urn:uuid:'.$value;
        $variations[] = '{'.$value.'}';

        foreach ($variations as $variation) {
            $variations[] = strtoupper($variation);
        }

        foreach ($variations as $variation) {
            $this->assertSame($expected, Val::uuid($variation));
        }
    }
}
