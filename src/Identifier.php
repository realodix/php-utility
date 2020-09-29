<?php

namespace Realodix\Utils;

use Nicebooks\Isbn\IsbnTools;
use Ramsey\Uuid\Codec\TimestampFirstCombCodec;
use Ramsey\Uuid\Generator\CombGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class Identifier
{
    /**
     * Convert the unformatted ISBN-10 to ISBN-13.
     *
     * @param string $isbn — The ISBN-10 to convert.
     * @return string — The converted, unformatted ISBN-13.
     */
    public static function isbn10to13(string $isbn): string
    {
        return (new IsbnTools())->convertIsbn10to13($isbn);
    }

    /**
     * Convert the unformatted ISBN-13 to ISBN-10.
     *
     * @param string $isbn — The ISBN-13 to convert.
     * @return string — The converted, unformatted ISBN-10.
     */
    public static function isbn13to10(string $isbn): string
    {
        return (new IsbnTools())->convertIsbn13to10($isbn);
    }

    /**
     * Format the ISBN number.
     *
     * @param string $isbn — The ISBN-10 or ISBN-13 number.
     * @return string — The formatted ISBN number.
     */
    public static function isbnFormat(string $isbn): string
    {
        return (new IsbnTools())->format($isbn);
    }

    /**
     * Generate a UUID (version 4).
     * https://uuid.ramsey.dev/en/latest/rfc4122/version4.html
     *
     * @return \Ramsey\Uuid\UuidInterface
     */
    public static function uuid()
    {
        return Uuid::uuid4();
    }

    /**
     * Generate a time-ordered UUID (version 4).
     *
     * @return \Ramsey\Uuid\UuidInterface
     */
    public static function uuidOrdered()
    {
        $factory = new UuidFactory();

        $factory->setRandomGenerator(new CombGenerator(
            $factory->getRandomGenerator(),
            $factory->getNumberConverter()
        ));

        $factory->setCodec(new TimestampFirstCombCodec(
            $factory->getUuidBuilder()
        ));

        return $factory->uuid4();
    }
}
