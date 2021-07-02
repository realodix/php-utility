<?php

namespace Realodix\Utils;

class Validator
{
    /**
     * Validates whether the input follows the Fibonacci integer sequence.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function fibonacci($value): bool
    {
        if (! is_numeric($value)) {
            return false;
        }

        $sequence = [0, 1];
        $position = 1;

        while ($value > $sequence[$position]) {
            $position++;
            $sequence[$position] = $sequence[$position - 1] + $sequence[$position - 2];
        }

        return $sequence[$position] === (int) $value;
    }

    /**
     * Validates that a value is a valid LUHN.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function luhn($value): bool
    {
        if (! ctype_digit($value)) {
            return false;
        }

        $checkSum = 0;
        $length = \strlen($value);

        // Starting with the last digit and walking left, add every second digit to the
        // check sum
        // e.g. 7  9  9  2  7  3  9  8  7  1  3
        //      ^     ^     ^     ^     ^     ^
        //    = 7  +  9  +  7  +  9  +  7  +  3
        for ($i = $length - 1; $i >= 0; $i -= 2) {
            $checkSum += $value[$i];
        }

        // Starting with the second last digit and walking left, double every second digit
        // and add it to the check sum. For doubles greater than 9, sum the individual
        // digits
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
