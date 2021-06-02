<?php

namespace Realodix\Utils\Validator;

use Nicebooks\Isbn\IsbnTools;

trait IdentificationsTrait
{
    /**
     * Ensures that a credit card number is valid for a given credit card
     * company.
     *
     * @param string $cNumber
     * @param array  $scheme
     *
     * @return bool
     */
    public static function creditCard($cNumber, $scheme): bool
    {
        if (! is_numeric($cNumber)) {
            return false;
        }

        $creditCard = array_flip((array) $scheme);
        $schemeRegexes = array_intersect_key(self::CARD_SCHEMES, $creditCard);

        foreach ($schemeRegexes as $regexes) {
            foreach ($regexes as $regex) {
                if (preg_match($regex, $cNumber)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Validates that an International Standard Book Number (ISBN) is either a valid
     * ISBN-10 or a valid ISBN-13.
     *
     * @param string $value
     * @return bool
     */
    public static function isbn(string $value): bool
    {
        $isbn = str_replace(['ISBN', '-10:', '-13:', '-', ' '], '', $value);

        return (new IsbnTools())->isValidIsbn($isbn);
    }

    public static function isbnIs10(string $value): bool
    {
        $isbn = str_replace(['ISBN', '-10:', '-13:', '-', ' '], '', $value);

        return (new IsbnTools())->isValidIsbn10($isbn);
    }

    public static function isbnIs13(string $value): bool
    {
        $isbn = str_replace(['ISBN', '-10:', '-13:', '-', ' '], '', $value);

        return (new IsbnTools())->isValidIsbn13($isbn);
    }

    /**
     * Validates that a value is a valid International Standard Serial Number (ISSN).
     *
     * @param string $value
     * @param bool   $caseSensitive
     * @return bool
     */
    public static function issn($value, bool $caseSensitive = false): bool
    {
        if (null === $value || '' === $value) {
            return false;
        }

        $canonical = (string) $value;

        // 1234-567X
        //     ^
        if (isset($canonical[4]) && '-' === $canonical[4]) {
            // remove hyphen
            $canonical = substr($canonical, 0, 4).substr($canonical, 5);
        }

        $length = strlen($canonical);
        if ($length < 8 || $length > 8) {
            return false;
        }

        if (// 1234567X
            // ^^^^^^^ digits only
            ! ctype_digit(substr($canonical, 0, 7))

            // 1234567X
            //        ^ digit, x or X
            || ! ctype_digit($canonical[7]) && 'x' !== $canonical[7] && 'X' !== $canonical[7]
        ) {
            return false;
        }

        // 1234567X
        //        ^ case-sensitive?
        if ($caseSensitive && 'x' === $canonical[7]) {
            return false;
        }

        // Calculate a checksum. "X" equals 10.
        $checkSum = 'X' === $canonical[7]
        || 'x' === $canonical[7]
        ? 10
            : $canonical[7];

        for ($i = 0; $i < 7; $i++) {
            // Multiply the first digit by 8, the second by 7, etc.
            $checkSum += (8 - $i) * (int) $canonical[$i];
        }

        if (0 !== $checkSum % 11) {
            return false;
        }

        return true;
    }

    /**
     * Validates that a value is a valid LUHN.
     *
     * @param string $value
     * @return bool
     */
    public static function luhn($value): bool
    {
        if (! ctype_digit($value)) {
            return false;
        }

        $checkSum = 0;
        $length = \strlen($value);

        // Starting with the last digit and walking left, add every second digit to the check sum
        // e.g. 7  9  9  2  7  3  9  8  7  1  3
        //      ^     ^     ^     ^     ^     ^
        //    = 7  +  9  +  7  +  9  +  7  +  3
        for ($i = $length - 1; $i >= 0; $i -= 2) {
            $checkSum += $value[$i];
        }

        // Starting with the second last digit and walking left, double every second digit and add
        // it to the check sum. For doubles greater than 9, sum the individual digits
        // e.g. 7  9  9  2  7  3  9  8  7  1  3
        //         ^     ^     ^     ^     ^
        //    =    1+8 + 4  +  6  +  1+6 + 2
        for ($i = $length - 2; $i >= 0; $i -= 2) {
            $checkSum += array_sum(mb_str_split((int) $value[$i] * 2));
        }

        if (0 === $checkSum || 0 !== $checkSum % 10) {
            return false;
        }

        return true;
    }
}
