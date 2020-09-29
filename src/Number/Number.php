<?php

namespace Realodix\Utils\Number;

use NumberFormatter;
use Symfony\Polyfill\Php74\Php74;

class Number
{
    /**
     * Default locale.
     */
    public const DEFAULT_LOCALE = 'en_US';

    /**
     * Format type to format as currency.
     */
    public const FORMAT_CURRENCY = 'currency';

    /**
     * Format type to format as currency, accounting style (negative numbers in
     * parentheses).
     */
    public const FORMAT_CURRENCY_ACCOUNTING = 'currency_accounting';

    /**
     * ICU Constant for accounting format; not yet widely supported by INTL library. This
     * will be able to go away once minimum PHP requirement is 7.4.1 or higher.
     * See UNUM_CURRENCY_ACCOUNTING in https://unicode-org.github.io/icu-docs/apidoc/released/icu4c/unum_8h.html
     */
    public const CURRENCY_ACCOUNTING = 12;

    /**
     * A list of number formatters indexed by locale and type.
     */
    protected static $_formatters = [];

    /**
     * Convert alphabetic characters to ordinals.
     *
     * @param string $value
     * @return string
     */
    public static function charToInt(string $value): string
    {
        $chars = Php74::mb_str_split($value);
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
     * @return string
     */
    public static function charUpperToInt(string $value): string
    {
        $chars = Php74::mb_str_split($value);
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
     * @return string
     */
    public static function charLowerToInt(string $value): string
    {
        $chars = Php74::mb_str_split($value);
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
     * Formats a number into the correct locale format
     *
     * @param float|string $value   A floating point number.
     * @param array        $options An array with options.
     *
     * @return string Formatted number
     */
    public static function format($value, array $options = []): string
    {
        $formatter = static::formatter($options);
        $options += ['before' => '', 'after' => ''];

        return $options['before'].$formatter->format((float) $value).$options['after'];
    }

    /**
     * Formats a number into the correct locale format to show deltas (signed differences
     * in value).
     *
     * @param float|string $value   A floating point number
     * @param array        $options Options list.
     *
     * @return string formatted delta
     */
    public static function formatDelta($value, array $options = []): string
    {
        $options += ['places' => 0];
        $value = number_format((float) $value, $options['places'], '.', '');
        $sign = $value > 0 ? '+' : '';
        $options['before'] = isset($options['before']) ? $options['before'].$sign : $sign;

        return static::format($value, $options);
    }

    /**
     * Returns a formatted integer as an ordinal number string (e.g. 1st, 2nd, 3rd, 4th,
     * [...]). For all other options see formatter().
     *
     * @param int|float $value   An integer
     * @param array     $options An array with options.
     *
     * @return string
     */
    public static function ordinal($value, array $options = []): string
    {
        return static::formatter(['type' => NumberFormatter::ORDINAL] + $options)->format($value);
    }

    /**
     * Formats a number with a level of precision.
     *
     * Options:
     * - `locale`: The locale name to use for formatting the number, e.g. fr_FR
     *
     * @param float|string $value     A floating point number.
     * @param int          $precision The precision of the returned number.
     * @param array        $options   Additional options
     *
     * @return string Formatted float.
     */
    public static function precision($value, int $precision = 2, array $options = []): string
    {
        $formatter = static::formatter(['precision' => $precision, 'places' => $precision] + $options);

        return $formatter->format($value);
    }

    /**
     * Converts numbers to a more readable representation when dealing with very large
     * numbers (in the thousands or above), up to the quadrillions, because you won't
     * often deal with numbers larger than that.
     *
     * It uses the "short form" numbering system as this is most commonly used within
     * most English-speaking countries today.
     *
     * @see https://simple.wikipedia.org/wiki/Names_for_large_numbers
     *
     * @param string $num
     * @param int    $precision
     *
     * @return bool|string
     */
    public static function toAmount($num, int $precision = 0)
    {
        // Strip any formatting & ensure numeric input
        try {
            $num = 0 + str_replace(',', '', $num);
        } catch (\ErrorException $ee) {
            return false;
        }

        $suffix = '';

        if ($num > 1000000000000000) {
            $suffix = 'quadrillion';
            $num = round(($num / 1000000000000000), $precision);
        } elseif ($num > 1000000000000) {
            $suffix = 'trillion';
            $num = round(($num / 1000000000000), $precision);
        } elseif ($num > 1000000000) {
            $suffix = 'billion';
            $num = round(($num / 1000000000), $precision);
        } elseif ($num > 1000000) {
            $suffix = 'million';
            $num = round(($num / 1000000), $precision);
        } elseif ($num > 1000) {
            $suffix = 'thousand';
            $num = round(($num / 1000), $precision);
        }

        return static::format($num, ['precision' => $precision, 'after' => ' '.$suffix]);
    }

    /**
     * Convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+,
     * 1B+ etc.
     * Based on: ({@link https://gist.github.com/RadGH/84edff0cc81e6326029c}).
     *
     * @param int $n
     * @return int|string
     */
    public static function toAmountShort(int $n)
    {
        $nFormat = floor($n);
        $suffix = '';

        if ($n >= pow(10, 3) && $n < pow(10, 6)) {
            // 1k-999k
            $nFormat = static::numbPrec($n / pow(10, 3));
            $suffix = 'K+';

            if (($n / pow(10, 3) == 1) || ($n / pow(10, 4) == 1) || ($n / pow(10, 5) == 1)) {
                $suffix = 'K';
            }
        } elseif ($n >= pow(10, 6) && $n < pow(10, 9)) {
            // 1m-999m
            $nFormat = static::numbPrec($n / pow(10, 6));
            $suffix = 'M+';

            if (($n / pow(10, 6) == 1) || ($n / pow(10, 7) == 1) || ($n / pow(10, 8) == 1)) {
                $suffix = 'M';
            }
        } elseif ($n >= pow(10, 9) && $n < pow(10, 12)) {
            // 1b-999b
            $nFormat = static::numbPrec($n / pow(10, 9));
            $suffix = 'B+';

            if (($n / pow(10, 9) == 1) || ($n / pow(10, 10) == 1) || ($n / pow(10, 11) == 1)) {
                $suffix = 'B';
            }
        } elseif ($n >= pow(10, 12)) {
            // 1t+
            $nFormat = static::numbPrec($n / pow(10, 12));
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
     * @param array        $options   Options
     *
     * @return string Percentage string
     */
    public static function toPercentage($value, int $precision = 2, array $options = []): string
    {
        $options += ['multiply' => false, 'type' => NumberFormatter::PERCENT];

        if (! $options['multiply']) {
            $value /= 100;
        }

        return static::precision($value, $precision, $options);
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
     * Returns a formatter object that can be reused for similar formatting task under the
     * same locale and options. This is often a speedier alternative to using other
     * methods in this class as only one formatter object needs to be constructed.
     *
     * ### Options
     * - `locale`:      The locale name to use for formatting the number, e.g. fr_FR
     * - `type`:        The formatter type to construct, set it to `currency` if you need
     *                  to format numbers representing money or a NumberFormatter constant.
     * - `places`:      Number of decimal places to use. e.g. 2
     * - `precision`:   Maximum Number of decimal places to use, e.g. 2
     * - `pattern`:     An ICU number pattern to use for formatting the number. e.g #,##0.00
     * - `useIntlCode`: Whether or not to replace the currency symbol with the international
     *                  currency code.
     *
     * @param array $options An array with options.
     * @return \NumberFormatter The configured formatter instance
     */
    public static function formatter(array $options = []): NumberFormatter
    {
        $locale = $options['locale'] ?? static::DEFAULT_LOCALE;

        $type = NumberFormatter::DECIMAL;
        if (! empty($options['type'])) {
            $type = $options['type'];
            if ($options['type'] === static::FORMAT_CURRENCY) {
                $type = NumberFormatter::CURRENCY;
            } elseif ($options['type'] === static::FORMAT_CURRENCY_ACCOUNTING) {
                if (defined('NumberFormatter::CURRENCY_ACCOUNTING')) {
                    $type = NumberFormatter::CURRENCY_ACCOUNTING;
                } else {
                    $type = static::CURRENCY_ACCOUNTING;
                }
            }
        }

        if (! isset(static::$_formatters[$locale][$type])) {
            static::$_formatters[$locale][$type] = new NumberFormatter($locale, $type);
        }

        // \NumberFormatter $formatter
        $formatter = static::$_formatters[$locale][$type];

        $options = array_intersect_key($options, [
            'places'      => null,
            'precision'   => null,
            'pattern'     => null,
            'useIntlCode' => null,
        ]);
        if (empty($options)) {
            return $formatter;
        }

        $formatter = clone $formatter;

        return static::_setAttributes($formatter, $options);
    }

    /**
     * Set formatter attributes.
     *
     * @param \NumberFormatter $formatter Number formatter instance.
     * @param array            $options   See Number::formatter() for possible options.
     *
     * @return \NumberFormatter
     */
    protected static function _setAttributes(NumberFormatter $formatter, array $options = []): NumberFormatter
    {
        if (isset($options['places'])) {
            $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $options['places']);
        }

        if (isset($options['precision'])) {
            $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $options['precision']);
        }

        if (! empty($options['pattern'])) {
            $formatter->setPattern($options['pattern']);
        }

        if (! empty($options['useIntlCode'])) {
            // One of the odd things about ICU is that the currency marker in patterns is
            // denoted with ¤, whereas the international code is marked with ¤¤, in order
            // to use the code we need to simply duplicate the character wherever it
            // appears in the pattern.
            $pattern = trim(str_replace('¤', '¤¤ ', $formatter->getPattern()));
            $formatter->setPattern($pattern);
        }

        return $formatter;
    }

    /**
     * Calculates the MOD-97-10 of the passed number as specified in ISO7064.
     *
     * @param string $bigInt
     * @return int
     */
    public static function mod97(string $bigInt): int
    {
        $parts = Php74::mb_str_split($bigInt, 7);
        $rest = 0;

        foreach ($parts as $part) {
            $rest = ($rest.$part) % 97;
        }

        return $rest;
    }

    /**
     * Alternative to make number_format() not to round numbers up.
     *
     * Based on: (@link https://stackoverflow.com/q/3833137).
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
