<?php

namespace Realodix\Utils\Validator;

trait NumberTrait
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
}
