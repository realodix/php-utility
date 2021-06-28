<?php

namespace Realodix\Utils\Validator;

trait StringTrait
{
    /**
     * Determine if a given string contains all array values.
     *
     * @param string   $haystack
     * @param string[] $needles
     *
     * @return bool
     */
    public static function containsAll(string $haystack, array $needles)
    {
        foreach ($needles as $needle) {
            if (! str_contains($haystack, $needle)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validates weather the input is a hex RGB color or not.
     *
     * @param mixed $input
     *
     * @return string
     */
    public static function hexRgbColor($input)
    {
        return preg_match('/^#?([0-9A-F]{3}|[0-9A-F]{6})$/', $input) > 0;
    }

    /**
     * Checks if the array is indexed in ascending order of numeric keys from zero,
     * a.k.a list.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function list($value): bool
    {
        return is_array($value) && (! $value || array_keys($value) === range(0, count($value) - 1));
    }

    /**
     * Checks if the value is in the given range [min, max], where the upper or lower
     * limit can be omitted (null). Numbers, strings and DateTime objects can be compared.
     * If both boundaries are missing ([null, null]) or the value is null, it returns
     * false.
     *
     * @param mixed $value
     * @param array $range
     *
     * @return bool
     */
    public static function range($value, array $range): bool
    {
        if ($value === null || ! (isset($range[0]) || isset($range[1]))) {
            return false;
        }
        $limit = $range[0] ?? $range[1];
        if (is_string($limit)) {
            $value = (string) $value;
        } elseif ($limit instanceof \DateTimeInterface) {
            if (! $value instanceof \DateTimeInterface) {
                return false;
            }
        } elseif (is_numeric($value)) {
            $value *= 1;
        } else {
            return false;
        }

        return (! isset($range[0]) || ($value >= $range[0])) && (! isset($range[1]) || ($value <= $range[1]));
    }
}
