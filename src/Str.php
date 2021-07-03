<?php

namespace Realodix\Utils;

class Str
{
    /**
     * Returns the character at $index, with indexes starting at 0.
     *
     * @param string $str
     * @param int    $index Position of the character.
     *
     * @return string The character at $index.
     */
    public static function charAt(string $str, int $index): string
    {
        return (string) mb_substr($str, $index, 1);
    }

    public static function hasLowercase(string $str): bool
    {
        return mb_ereg_match('.*[[:lower:]]', $str);
    }

    public static function hasUppercase(string $str): bool
    {
        return mb_ereg_match('.*[[:upper:]]', $str);
    }

    public static function isAscii(string $str): bool
    {
        $regexAscii = "[^\x09\x10\x13\x0A\x0D\x20-\x7E]";

        if ($str === '') {
            return true;
        }

        return ! preg_match('/'.$regexAscii.'/', $str);
    }

    /**
     * Makes string's first char lowercase.
     *
     * @param string $str
     */
    public static function lcfirst(string $str): string
    {
        $strPartOne = mb_strtolower(mb_substr($str, 0, 1));
        $strPartTwo = mb_substr($str, 1);

        return $strPartOne.$strPartTwo;
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param string $str
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    public static function limit(string $str, $limit = 100, $end = '...')
    {
        if (mb_strwidth($str) <= $limit) {
            return $str;
        }

        return rtrim(mb_strimwidth($str, 0, $limit, '')).$end;
    }

    /**
     * Limit the number of words in a string.
     *
     * @param string $str
     * @param int    $words
     * @param string $end
     *
     * @return string
     */
    public static function limitWord(string $str, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $str, $matches);

        if (! isset($matches[0]) || mb_strlen($str) === mb_strlen($matches[0])) {
            return $str;
        }

        return rtrim($matches[0]).$end;
    }

    /**
     * Returns the substring beginning at $start, and up to, but not including the index
     * specified by $end. If $end is omitted, the function extracts the remaining string.
     * If $end is negative, it is computed from the end of the string.
     *
     * @param string   $str
     * @param int      $start Initial index from which to begin extraction.
     * @param int|null $end   [optional] Index at which to end extraction. Default: null
     *
     * @return false|string The extracted substring. If str is shorter than start
     *                      characters long, FALSE will be returned.
     */
    public static function slice(string $str, int $start, int $end = null)
    {
        if ($end === null) {
            $length = (int) mb_strlen($str);
        } elseif ($end >= 0 && $end <= $start) {
            return '';
        } elseif ($end < 0) {
            $length = (int) mb_strlen($str) + $end - $start;
        } else {
            $length = $end - $start;
        }

        return mb_substr($str, $start, $length);
    }

    /**
     * Strip HTML, PHP and shortcode tags from a string.
     *
     * @param string $str
     *
     * @return string|empty
     */
    public static function stripTags(string $str)
    {
        $content = strip_tags($str);

        if (false === strpos($content, '[')) {
            return $content;
        }

        $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
        $content = preg_replace("/${pattern}/", '', $content);

        return $content;
    }

    public static function strToWords(string $str, string $charList = '', bool $removeEmptyValues = false, int $removeShortValues = null): array
    {
        if ($str === '') {
            return $removeEmptyValues ? [] : [''];
        }

        $charList = self::rxClass($charList, '\pL');

        $return = preg_split("/({$charList}+(?:[\p{Pd}’']{$charList}+)*)/u", $str, -1, \PREG_SPLIT_DELIM_CAPTURE);
        if ($return === false) {
            return $removeEmptyValues ? [] : [''];
        }

        if ($removeShortValues === null && ! $removeEmptyValues) {
            return $return;
        }

        $tmp_return = self::reduceStringArray($return, $removeEmptyValues, $removeShortValues);

        foreach ($tmp_return as &$item) {
            $item = (string) $item;
        }

        return $tmp_return;
    }

    public static function ucfirst(string $str): string
    {
        $str_part_one = mb_strtoupper(mb_substr($str, 0, 1));
        $str_part_two = mb_substr($str, 1);

        return $str_part_one.$str_part_two;
    }

    public static function ucwords(string $str, array $exceptions = [], string $charList = ''): string
    {
        $use_php_default_functions = ! (bool) ($charList.implode('', $exceptions));

        if ($use_php_default_functions && self::isAscii($str)) {
            return ucwords($str);
        }

        $words = self::strToWords($str, $charList);
        $use_exceptions = $exceptions !== [];

        $words_str = '';
        foreach ($words as &$word) {
            if (! $word) {
                continue;
            }

            if (! $use_exceptions || ! \in_array($word, $exceptions, true)) {
                $words_str .= self::ucfirst($word);
            } else {
                $words_str .= $word;
            }
        }

        return $words_str;
    }

    private static function reduceStringArray(array $strings, bool $removeEmptyValues, int $removeShortValues = null)
    {
        // init
        $return = [];

        foreach ($strings as &$str) {
            if ($removeShortValues !== null && mb_strlen($str) <= $removeShortValues) {
                continue;
            }

            if ($removeEmptyValues && trim($str) === '') {
                continue;
            }

            $return[] = $str;
        }

        return $return;
    }

    private static function rxClass(string $s, string $class = '')
    {
        static $RX_CLASS_CACHE = [];

        $cache_key = $s.'_'.$class;

        if (isset($RX_CLASS_CACHE[$cache_key])) {
            return $RX_CLASS_CACHE[$cache_key];
        }

        $class_array[] = $class;

        foreach (mb_str_split($s) as &$s) {
            if ($s === '-') {
                $class_array[0] = '-'.$class_array[0];
            } elseif (! isset($s[2])) {
                $class_array[0] .= preg_quote($s, '/');
            } elseif (mb_strlen($s) === 1) {
                $class_array[0] .= $s;
            } else {
                $class_array[] = $s;
            }
        }

        if ($class_array[0]) {
            $class_array[0] = '['.$class_array[0].']';
        }

        if (count($class_array) === 1) {
            $return = $class_array[0];
        } else {
            $return = '(?:'.implode('|', $class_array).')';
        }

        $RX_CLASS_CACHE[$cache_key] = $return;

        return $return;
    }
}
