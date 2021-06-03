<?php

namespace Realodix\Utils;

use Realodix\Utils\String\ChangeCase;
use Realodix\Utils\String\ReadTime;
use voku\helper\ASCII;

class Str
{
    /**
     * Initializes a string object and assigns str properties to the supplied values. $str
     * is cast to a string prior to assignment.
     *
     * @param mixed $str [optional] Value to modify, after being cast to string.
     *                   Default: ''
     */
    public function __construct(
        protected $str = ''
    ) {
        $this->str = (string) $str;
    }

    /**
     * Returns the value in $str.
     *
     * @return string The current value of the $str property.
     */
    public function __toString()
    {
        return (string) $this->str;
    }

    /**
     *
     */
    public static function of($str = ''): self
    {
        return new static($str);
    }

    /**
     * Returns the character at $index, with indexes starting at 0.
     *
     * @param int $index Position of the character.
     *
     * @return string The character at $index.
     */
    public function charAt(int $index): string
    {
        return (string) mb_substr($this->str, $index, 1);
    }

    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc
     *
     * @param string $separator What should the duplicate number be appended with
     * @param int    $first     Which number should be used for the first dupe increment
     *
     * @return string
     */
    public function incrementString(string $separator = '_', int $first = 1): string
    {
        $str = $this->str;
        preg_match('/(.+)'.preg_quote($separator, '/').'([0-9]+)$/', $str, $match);

        return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param int    $limit
     * @param string $end
     *
     * @return string
     */
    public function limit($limit = 100, $end = '...')
    {
        $value = $this->str;

        if (mb_strwidth($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '')).$end;
    }

    /**
     * Limit the number of words in a string.
     *
     * @param int    $words
     * @param string $end
     *
     * @return string
     */
    public function limitWord($words = 100, $end = '...')
    {
        $value = $this->str;

        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

        if (! isset($matches[0]) || mb_strlen($value) === mb_strlen($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]).$end;
    }

    /**
     * Calculate the estimated reading time in seconds for a given piece of content.
     *
     * @param int $wpm Estimated words per minute of reader
     *
     * @return string|empty
     */
    public function readTime(int $wpm = 265): string
    {
        return (new ReadTime)->readTime($this->str, $wpm);
    }

    /**
     * Remove non-alpha characters.
     *
     * @return string|empty
     */
    public function removeNonAlpha()
    {
        return preg_replace('/[^a-z]/i', '', $this->str);
    }

    /**
     * Remove non-alphanumeric characters.
     *
     * @return string|empty
     */
    public function removeNonAlphaNum()
    {
        return preg_replace('/[^a-z0-9]/i', '', $this->str);
    }

    /**
     * Remove non-numeric characters.
     *
     * @return string|empty
     */
    public function removeNonNumeric()
    {
        return preg_replace('/[^0-9]/i', '', $this->str);
    }

    /**
     * Returns the substring beginning at $start, and up to, but not including the index
     * specified by $end. If $end is omitted, the function extracts the remaining string.
     * If $end is negative, it is computed from the end of the string.
     *
     * @param int      $start Initial index from which to begin extraction.
     * @param int|null $end   [optional] Index at which to end extraction. Default: null
     *
     * @return false|string The extracted substring. If str is shorter than start
     *                      characters long, FALSE will be returned.
     */
    public function slice(int $start, int $end = null)
    {
        $str = $this->str;

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
     * @return string|empty
     */
    public function stripTags()
    {
        $content = strip_tags($this->str);

        if (false === strpos($content, '[')) {
            return $content;
        }

        $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
        $content = preg_replace("/$pattern/", '', $content);

        return $content;
    }

    /**
     * Transliterate a UTF-8 value to ASCII.
     *
     * @param string $language          Language of the source string.
     * @param bool   $removeUnsupported Whether or not to remove the unsupported
     *                                  characters.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public static function toAscii(string $language = 'en', bool $removeUnsupported = true)
    {
        $str = this->str;

        return ASCII::to_ascii($str, $language, $removeUnsupported);
    }

    /**
     * -----------------------------------------------------------------------------------
     * CHANGE CASE
     * -----------------------------------------------------------------------------------
     */

    // @codeCoverageIgnoreStart

    public static function noCase($string, $delimiter = ' ')
    {
        return (new ChangeCase)->noCase($string, $delimiter);
    }

    public static function camelCase($string)
    {
        return (new ChangeCase)->camelCase($string);
    }

    public static function capitalCase($string)
    {
        return (new ChangeCase)->capitalCase($string);
    }

    public static function constantCase($string)
    {
        return (new ChangeCase)->constantCase($string);
    }

    public static function dotCase($string)
    {
        return (new ChangeCase)->dotCase($string);
    }

    public static function headerCase($string)
    {
        return (new ChangeCase)->headerCase($string);
    }

    public static function pascalCase($string)
    {
        return (new ChangeCase)->pascalCase($string);
    }

    public static function pathCase($string)
    {
        return (new ChangeCase)->pathCase($string);
    }

    public static function sentenceCase($string)
    {
        return (new ChangeCase)->sentenceCase($string);
    }

    public static function snakeCase($string)
    {
        return (new ChangeCase)->snakeCase($string);
    }

    public static function spinalCase($string)
    {
        return (new ChangeCase)->spinalCase($string);
    }

    public static function swapCase($string)
    {
        return (new ChangeCase)->swapCase($string);
    }

    public static function titleCase($string)
    {
        return (new ChangeCase)->titleCase($string);
    }

    // @codeCoverageIgnoreEnd
}
