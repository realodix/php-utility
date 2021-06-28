<?php

namespace Realodix\Utils;

use Realodix\ChangeCase\ChangeCase;
use Realodix\ReadTime\ReadTime;
use voku\helper\ASCII;

class Str
{
    protected $str = '';

    /**
     * Initializes a string object and assigns str properties to the supplied values. $str
     * is cast to a string prior to assignment.
     *
     * @param mixed $str [optional] Value to modify, after being cast to string.
     *                   Default: ''
     */
    public function __construct(string $str)
    {
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
     * @param mixed $str
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
        $content = preg_replace("/${pattern}/", '', $content);

        return $content;
    }

    // @codeCoverageIgnoreStart

    /**
     * Calculate the estimated reading time in seconds for a given piece of content.
     *
     * @param int $wordSpeed
     * @param int $imageTime
     * @param int $cjkSpeed
     *
     * @return \Realodix\ReadTime\ReadTime
     */
    public function readTime(int $wordSpeed = 265, int $imageTime = 12, int $cjkSpeed = 500)
    {
        return new ReadTime($this->str, $wordSpeed, $imageTime, $cjkSpeed);
    }

    public function noCase()
    {
        return (new ChangeCase)->no($this->str);
    }

    public function camelCase()
    {
        return (new ChangeCase)->camel($this->str);
    }

    public function capitalCase()
    {
        return (new ChangeCase)->capital($this->str);
    }

    public function constantCase()
    {
        return (new ChangeCase)->constant($this->str);
    }

    public function dotCase()
    {
        return (new ChangeCase)->dot($this->str);
    }

    public function headerCase()
    {
        return (new ChangeCase)->header($this->str);
    }

    public function pascalCase()
    {
        return (new ChangeCase)->pascal($this->str);
    }

    public function pathCase()
    {
        return (new ChangeCase)->path($this->str);
    }

    public function sentenceCase()
    {
        return (new ChangeCase)->sentence($this->str);
    }

    public function snakeCase()
    {
        return (new ChangeCase)->snake($this->str);
    }

    public function spinalCase()
    {
        return (new ChangeCase)->spinal($this->str);
    }

    public function swapCase()
    {
        return (new ChangeCase)->swap($this->str);
    }

    // @codeCoverageIgnoreEnd
}
