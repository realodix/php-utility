<?php

namespace Realodix\Utils\Validator;

trait InternetTrait
{
    /**
     * Validates that a value is a valid URL string.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function url(string $value): bool
    {
        return preg_match(self::URL_REGEX_PATTERN, $value) > 0;
    }
}
