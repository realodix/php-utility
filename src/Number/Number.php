<?php

namespace Realodix\Utils\Number;

class Number
{
    /**
     * Convert alphabetic characters to ordinals.
     *
     * @param string $value
     *
     * @return string
     */
    public static function charToInt(string $value): string
    {
        $chars = mb_str_split($value);
        $bigInt = '';

        foreach ($chars as $char) {
            if (ctype_alpha($char)) {
                $bigInt .= (ord($char) - 55);
                continue;
            }

            // Simply append digits
            $bigInt .= $char;
        }

        return $bigInt;
    }

    /**
     * Convert uppercase characters to ordinals.
     *
     * @param string $value
     *
     * @return string
     */
    public static function charUpperToInt(string $value): string
    {
        $chars = mb_str_split($value);
        $bigInt = '';

        foreach ($chars as $char) {
            if (ctype_upper($char)) {
                $bigInt .= (ord($char) - 55);
                continue;
            }

            // Simply append digits
            $bigInt .= $char;
        }

        return $bigInt;
    }

    /**
     * Convert uppercase characters to ordinals.
     *
     * @param string $value
     *
     * @return string
     */
    public static function charLowerToInt(string $value): string
    {
        $chars = mb_str_split($value);
        $bigInt = '';

        foreach ($chars as $char) {
            if (ctype_lower($char)) {
                $bigInt .= (ord($char) - 55);
                continue;
            }

            // Simply append digits
            $bigInt .= $char;
        }

        return $bigInt;
    }

    /**
     * Formats a number with a level of precision.
     *
     * Options:
     * - `locale`: The locale name to use for formatting the number, e.g. fr_FR
     *
     * @param float|string $value     A floating point number.
     * @param int          $precision The precision of the returned number.
     * @param string       $locale
     *
     * @return string Formatted float.
     */
    public static function precision($value, int $precision = 2, string $locale = 'en_US'): string
    {
        $a = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
        $a->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $precision);
        $a->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $precision);

        return $a->format($value);
    }

    /**
     * Convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+,
     * 1B+ etc.
     * Based on: ({@link https://gist.github.com/RadGH/84edff0cc81e6326029c}).
     *
     * @param int $n
     *
     * @return int|string
     */
    public static function toAmountShort(int $n)
    {
        $nFormat = floor($n);
        $suffix = '';

        if ($n >= pow(10, 3) && $n < pow(10, 6)) {
            // 1k-999k
            $nFormat = self::numbPrec($n / pow(10, 3));
            $suffix = 'K+';

            if (($n / pow(10, 3) == 1) || ($n / pow(10, 4) == 1) || ($n / pow(10, 5) == 1)) {
                $suffix = 'K';
            }
        } elseif ($n >= pow(10, 6) && $n < pow(10, 9)) {
            // 1m-999m
            $nFormat = self::numbPrec($n / pow(10, 6));
            $suffix = 'M+';

            if (($n / pow(10, 6) == 1) || ($n / pow(10, 7) == 1) || ($n / pow(10, 8) == 1)) {
                $suffix = 'M';
            }
        } elseif ($n >= pow(10, 9) && $n < pow(10, 12)) {
            // 1b-999b
            $nFormat = self::numbPrec($n / pow(10, 9));
            $suffix = 'B+';

            if (($n / pow(10, 9) == 1) || ($n / pow(10, 10) == 1) || ($n / pow(10, 11) == 1)) {
                $suffix = 'B';
            }
        } elseif ($n >= pow(10, 12)) {
            // 1t+
            $nFormat = self::numbPrec($n / pow(10, 12));
            $suffix = 'T+';

            if (($n / pow(10, 12) == 1) || ($n / pow(10, 13) == 1) || ($n / pow(10, 14) == 1)) {
                $suffix = 'T';
            }
        }

        return ! empty($nFormat.$suffix) ? $nFormat.$suffix : 0;
    }

    /**
     * Formats a number into a percentage string.
     *
     * @param float|string $value     A floating point number
     * @param int          $precision The precision of the returned number
     * @param bool         $multiply
     * @param string       $locale
     *
     * @return string Percentage string
     */
    public static function toPercentage($value, int $precision = 2, bool $multiply = false, string $locale = 'en_US'): string
    {
        if ($multiply) {
            $value *= 100;
        }

        return self::precision($value, $precision, $locale).'%';
    }

    /**
     * Convert a number to a roman numeral.
     *
     * @param string $num it will convert to int
     *
     * @return string|null
     */
    public static function toRoman(string $num): ?string
    {
        $num = (int) $num;
        if ($num < 1 || $num > 3999) {
            return null;
        }

        $_number_to_roman = function ($num, $th) use (&$_number_to_roman) {
            $return = '';
            $key1 = null;
            $key2 = null;
            switch ($th) {
                case 1:
                    $key1 = 'I';
                    $key2 = 'V';
                    $key_f = 'X';
                    break;
                case 2:
                    $key1 = 'X';
                    $key2 = 'L';
                    $key_f = 'C';
                    break;
                case 3:
                    $key1 = 'C';
                    $key2 = 'D';
                    $key_f = 'M';
                    break;
                case 4:
                    $key1 = 'M';
                    break;
            }
            $n = $num % 10;
            switch ($n) {
                case 1:
                case 2:
                case 3:
                    $return = str_repeat($key1, $n);
                    break;
                case 4:
                    $return = $key1.$key2;
                    break;
                case 5:
                    $return = $key2;
                    break;
                case 6:
                case 7:
                case 8:
                    $return = $key2.str_repeat($key1, $n - 5);
                    break;
                case 9:
                    $return = $key1.$key_f; // @phpstan-ignore-line
                    break;
            }
            switch ($num) {
                case 10:
                    $return = $key_f; // @phpstan-ignore-line
                    break;
            }
            if ($num > 10) {
                $return = $_number_to_roman($num / 10, ++ $th).$return;
            }

            return $return;
        };

        return $_number_to_roman($num, 1);
    }

    /**
     * Returns a formatted-for-humans file size.
     *
     * @param int|string $size      Size in bytes
     * @param int        $precision
     *
     * @return string Human readable size
     */
    public static function toSize($size, int $precision = 2): string
    {
        $units = ['Bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $unitsCount = count($units) - 1; // Except `Byte` or `Bytes`
        $bytesPerKilo = 1024;

        if ($size == 1 || $size == 0) {
            $units = array_replace($units, [0 => 'Byte']);
        }

        $i = 0;
        $simpleSize = $size;
        while (($simpleSize / $bytesPerKilo) > 0.9999) {
            $simpleSize /= $bytesPerKilo;
            $i++;
        }

        if ($i > $unitsCount) {
            $margin = $size % $bytesPerKilo;

            return number_format((($size - $margin) / pow($bytesPerKilo, $unitsCount)) + $margin).' '.end($units);
        }

        return round($simpleSize, $precision).' '.$units[$i];
    }

    /**
     * Calculates the MOD-97-10 of the passed number as specified in ISO7064.
     *
     * @param string $bigInt
     *
     * @return int
     */
    public static function mod97(string $bigInt): int
    {
        $parts = mb_str_split($bigInt, 7);
        $rest = 0;

        foreach ($parts as $part) {
            $rest = ($rest.$part) % 97;
        }

        return $rest;
    }

    /**
     * Alternative to make number_format() not to round numbers up.
     *
     * Based on: (@see https://stackoverflow.com/q/3833137).
     *
     * @param float $number
     * @param int   $precision
     *
     * @return float
     */
    public static function numbPrec(float $number, int $precision = 2)
    {
        return floor($number * pow(10, $precision)) / pow(10, $precision);
    }
}
