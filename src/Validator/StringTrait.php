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
}
