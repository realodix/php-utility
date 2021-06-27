<?php

namespace Realodix\Utils\Validator;

trait NumberTrait
{
    /**
     * Validates that values are a multiple of the given number.
     *
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function divisibleBy($value1, $value2): bool
    {
        if (! is_numeric($value1) || ! is_numeric($value2) || ! abs($value2)) {
            return false;
        }

        $value1 = abs($value1);
        if (is_int($value1) && is_int($value2)) {
            return 0 === ($value1 % $value2);
        }

        $remainder = fmod($value1, $value2);
        if (! $remainder) {
            return true;
        }

        return sprintf('%.12e', $value2) === sprintf('%.12e', $remainder);
    }

    /**
     * Validates whether the input follows the Fibonacci integer sequence.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public static function fibonacci($input): bool
    {
        if (! is_numeric($input)) {
            return false;
        }

        $sequence = [0, 1];
        $position = 1;

        while ($input > $sequence[$position]) {
            $position++;
            $sequence[$position] = $sequence[$position - 1] + $sequence[$position - 2];
        }

        return $sequence[$position] === (int) $input;
    }

    /**
     * Checks if the value is a number or a number written in a string.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function numeric($value): bool
    {
        return is_float($value)
               || is_int($value)
               || (is_string($value) && preg_match('#^[+-]?[0-9]*[.]?[0-9]+$#D', $value));
    }

    /**
     * Checks if the value is an integer or a integer written in a string.
     *
     * @param mixed $value
     */
    public static function numericInt($value): bool
    {
        return is_int($value)
               || (is_string($value) && preg_match('#^[+-]?[0-9]+$#D', $value));
    }
}
