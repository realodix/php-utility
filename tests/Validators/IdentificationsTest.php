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
     */
    public function creditCard($creditCard, $cardNumber)
    {
        $this->assertTrue(Val::creditCard($cardNumber, $creditCard));
    }

    /**
     * @test
     * @dataProvider creditCardInvalidProvider
     */
    public function creditCardInvalid($creditCard, $cardNumber)
    {
        $this->assertFalse(Val::creditCard($cardNumber, $creditCard));
    }

    /**
     * @test
     * @dataProvider isbn10Provider
     */
    public function isbn($value)
    {
        $this->assertTrue(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn10InvalidProvider
     */
    public function isbnInvalid($value)
    {
        $this->assertFalse(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn13Provider
     */
    public function isbn13($value)
    {
        $this->assertTrue(Val::isbn($value));
    }

    /**
     * @test
     * @dataProvider isbn13InvalidProvider
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
     */
    public function issn($value)
    {
        $this->assertTrue(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidProvider
     */
    public function issnInvalid($value)
    {
        $this->assertFalse(Val::issn($value));
    }

    /**
     * @test
     * @dataProvider issnInvalidWithOptionsProvider
     */
    public function issnInvalidWithOptions($value, $options)
    {
        $this->assertFalse(Val::issn($value, $options));
    }

    /**
     * @test
     * @dataProvider luhnProvider
     */
    public function luhn($value)
    {
        $this->assertTrue(Val::luhn($value));
    }

    /**
     * @test
     * @dataProvider luhnInvalidProvider
     */
    public function luhnInvalid($value)
    {
        $this->assertFalse(Val::luhn($value));
    }
}
