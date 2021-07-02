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
}
