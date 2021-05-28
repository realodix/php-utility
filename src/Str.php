<?php

namespace Realodix\Utils;

use voku\helper\ASCII;

class Str
{
    /**
     * An instance's string.
     *
     * @var string
     */
    protected $str;

    /**
     * Initializes a string object and assigns str properties to the supplied values. $str
     * is cast to a string prior to assignment.
     *
     * @param mixed $str [optional] Value to modify, after being cast to string.
     *                   Default: ''
     */
    public function __construct($str = '')
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
     * This function will strip tags from a string, split it at its max_length and
     * ellipsize
     *
     * @param int    $max_length Max length of string
     * @param mixed  $position   int (1|0) or float, .5, .2, etc for position to split
     * @param string $ellipsis   ellipsis ; Default '...'
     *
     * @return string    Ellipsized string
     */
    public function ellipsize(int $max_length, $position = 1, string $ellipsis = '&hellip;'): string
    {
        // Strip tags
        $str = trim(strip_tags($this->str));

        // Is the string long enough to ellipsize?
        if (mb_strlen($str) <= $max_length) {
            return $str;
        }

        $beg = mb_substr($str, 0, (int) floor($max_length * $position));
        $position = ($position > 1) ? 1 : $position;

        if ($position === 1) {
            $end = mb_substr($str, 0, -($max_length - mb_strlen($beg)));
        } else {
            $end = mb_substr($str, -($max_length - mb_strlen($beg)));
        }

        return $beg.$ellipsis.$end;
    }

    /**
     * Allows to extract a piece of text surrounding a word or phrase.
     *
     * @param string $phrase   Phrase that will be searched for.
     * @param int    $radius   The amount of characters returned around the phrase.
     * @param string $ellipsis Ending that will be appended
     *
     * @return string
     *
     * If no $phrase is passed, will generate an excerpt of $radius characters from the
     * beginning of $text.
     */
    public function excerpt(string $phrase = null, int $radius = 100, string $ellipsis = '...'): string
    {
        $text = $this->str;

        if (isset($phrase)) {
            $phrasePos = stripos($text, $phrase);
            $phraseLen = mb_strlen($phrase);
        } elseif (! isset($phrase)) {
            $phrasePos = $radius / 2;
            $phraseLen = 1;
        }

        $pre = explode(' ', substr($text, 0, $phrasePos)); // @phpstan-ignore-line
        $pos = explode(' ', substr($text, $phrasePos + $phraseLen)); // @phpstan-ignore-line

        $prev = ' ';
        $post = ' ';
        $count = 0;

        foreach (array_reverse($pre) as $e) {
            if ((mb_strlen($e) + $count + 1) < $radius) {
                $prev = ' '.$e.$prev;
            }
            $count = ++ $count + mb_strlen($e);
        }

        $count = 0;

        foreach ($pos as $s) {
            if ((mb_strlen($s) + $count + 1) < $radius) {
                $post .= $s.' ';
            }
            $count = ++ $count + mb_strlen($s);
        }

        $ellPre = $phrase ? $ellipsis : '';

        return str_replace('  ', ' ', $ellPre.$prev.$phrase.$post.$ellipsis);
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
     * Reduces multiple instances of a particular character.
     *
     * Example:
     * - Fred, Bill,, Joe, Jimmy
     *
     * becomes:
     * - Fred, Bill, Joe, Jimmy
     *
     * @param string $character The character you wish to reduce
     * @param bool   $trim      TRUE/FALSE - whether to trim the character from the
     *                          beginning/end
     *
     * @return string
     */
    public function reduceMultiples(string $character = ',', bool $trim = false): string
    {
        $str = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $this->str);

        return ($trim) ? trim($str, $character) : $str;
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
     * Remove non-alpha characters.
     *
     * @return string|empty
     */
    public function removeNonAlphaNum()
    {
        return preg_replace('/[^a-z0-9]/i', '', $this->str);
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
        return ASCII::to_ascii($this->str, $language, $removeUnsupported);
    }

    /**
     * Wraps text at the specified character. Maintains the integrity of words. Anything
     * placed between {unwrap}{/unwrap} will not be word wrapped, nor will URLs.
     *
     * @param int $charlim = 76    the number of characters to wrap at
     *
     * @return string
     */
    public function wordWrap(int $charlim = 76): string
    {
        // Reduce multiple spaces
        $str = preg_replace('| +|', ' ', $this->str);

        // Standardize newlines
        if (strpos($str, "\r") !== false) {
            $str = str_replace(["\r\n", "\r"], "\n", $str);
        }

        // If the current word is surrounded by {unwrap} tags we'll strip the entire chunk
        // and replace it with a marker.
        $unwrap = [];

        if (preg_match_all('|\{unwrap\}(.+?)\{/unwrap\}|s', $str, $matches)) {
            for ($i = 0, $c = count($matches[0]); $i < $c; $i ++) {
                $unwrap[] = $matches[1][$i];
                $str = str_replace($matches[0][$i], '{{unwrapped'.$i.'}}', $str);
            }
        }

        // Use PHP's native function to do the initial wordwrap. We set the cut flag to
        // FALSE so that any individual words that are too long get left alone. In the
        // next step we'll deal with them.
        $str = wordwrap($str, $charlim, "\n", false);

        // Split the string into individual lines of text and cycle through them
        $output = '';

        foreach (explode("\n", $str) as $line) {
            // Is the line within the allowed character count? If so we'll join it to the
            // output and continue
            if (mb_strlen($line) <= $charlim) {
                $output .= $line."\n";
                continue;
            }

            $temp = '';

            while (mb_strlen($line) > $charlim) {
                // If the over-length word is a URL we won't wrap it
                if (preg_match('!\[url.+\]|://|www\.!', $line)) {
                    break;
                }
                // Trim the word down
                $temp .= mb_substr($line, 0, $charlim - 1);
                $line = mb_substr($line, $charlim - 1);
            }

            // If $temp contains data it means we had to split up an over-length word into
            // smaller chunks so we'll add it back to our current line
            if ($temp !== '') {
                $output .= $temp."\n".$line."\n";
            } else {
                $output .= $line."\n";
            }
        }

        // Put our markers back
        if (! empty($unwrap)) {
            foreach ($unwrap as $key => $val) {
                $output = str_replace('{{unwrapped'.$key.'}}', $val, $output);
            }
        }

        // remove any trailing newline
        $output = rtrim($output);

        return $output;
    }

    /**
     * -----------------------------------------------------------------------------------
     * CHANGE CASE
     * -----------------------------------------------------------------------------------
     */

    /**
     * Transform into a lower cased string with spaces between words.
     *
     * @param mixed $text
     * @param array $delimiter
     * @return string
     */
    public static function noCase($text, string $delimiter = ' ')
    {
        // Support camel case ("camelCase" -> "camel Case" and
        // "CAMELCase" -> "CAMEL Case").
        $splitRegexp = ['/([a-z0-9])([A-Z])/', '/([A-Z])([A-Z][a-z])/'];
        // Remove all non-word characters.
        $stripRegexp = '/[^a-zA-Z0-9]/i';

        $result = mb_strtolower(
            preg_replace($stripRegexp, $delimiter,
                preg_replace($splitRegexp, '$1 $2', $text)
            )
        );

        $result = str($result);

        $start = 0;
        $end = mb_strlen($result);

        // Trim the delimiter from around the output string.
        while ($result->charAt($start) === "\0") {
            $start++;
        }
        while ($result->charAt($end - 1) === "\0") {
            $end--;
        }

        // Transform each token independently.
        return implode($delimiter,
            explode("\0", $result->slice($start, $end))
        );
    }

    /**
     * Transform into a string with the separator denoted by the next word capitalized.
     *
     * @param string $text
     * @return string
     */
    public static function camelCase($text): string
    {
        return lcfirst(self::pascalCase($text));
    }

    /**
     * Transform into a space separated string with each word capitalized.
     */
    public static function capitalCase(string $string): string
    {
        return preg_replace_callback(
            '/^.| ./u',
            function (array $matches) {
                return mb_strtoupper($matches[0]);
            },
            self::noCase($string)
        );
    }

    /**
     * Transform into upper case string with an underscore between words.
     *
     * @param string $text
     * @return string
     */
    public static function constantCase($text): string
    {
        return mb_strtoupper(self::snakeCase($text));
    }

    /**
     * Transform into a lower case string with a period between words.
     *
     * @return string
     */
    public function dotCase(): string
    {
        return self::noCase($this->str, '.');
    }

    /**
     * Transform into a dash separated string of capitalized words.
     */
    public static function headerCase(string $string): string
    {
        return preg_replace_callback(
            '/^.|-./u',
            function (array $matches) {
                return mb_strtoupper($matches[0]);
            },
            self::noCase($string, '-')
        );
    }

    /**
     * Transform into a string of capitalized words without separators.
     *
     * @param string $text
     * @return string
     */
    public static function pascalCase($text): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', self::noCase($text)));

        return str_replace(' ', '', $value);
    }

    /**
     * Transform into a lower case string with slashes between words.
     *
     * @param string $text
     * @return string
     */
    public static function pathCase($text): string
    {
        return self::noCase($text, '/');
    }

    /**
     * Transform into a lower case with spaces between words, then capitalize the string.
     *
     * @param string $text
     * @return string
     */
    public static function sentenceCase($text): string
    {
        return ucfirst(self::noCase($text));
    }

    /**
     * Transform into a lower case string with underscores between words.
     *
     * @param string $text
     * @return string
     */
    public static function snakeCase($text): string
    {
        return self::noCase($text, '_');
    }

    /**
     * Transform into a lower cased string with dashes between words.
     *
     * @param string $text
     * @return string
     */
    public static function spinalCase($text): string
    {
        return self::noCase($text, '-');
    }

    /**
     * Transform a string by swapping every character from upper to lower case, or lower
     * to upper case.
     *
     * @param string $text
     * @return string
     */
    public static function swapCase($text): string
    {
        if ($text === '') {
            return '';
        }

        return (string) (mb_strtolower($text) ^ mb_strtoupper($text) ^ $text);
    }

    /**
     * Transform a string into title case following English rules.
     *
     * Reference
     * - https://github.com/Kroc/PHPtitleCase
     * - https://github.com/blakeembrey/change-case (packages/title-case)
     *
     * @param string $string
     * @return string
     */
    public static function titleCase($string): string
    {
        $smallWords = '/^(a(nd?|s|t)?|b(ut|y)|en|for|i[fn]|o[fnr]|only|over|tha[tn]|t(he|o)|up|upon|vs?\.?|via)[ \-]/i';

        // find each word (including punctuation attached)
        preg_match_all('/[\w\p{L}&`\'‘’"“\.@:\/\{\(\[<>_]+-? */u', $string, $match_1, PREG_OFFSET_CAPTURE);

        foreach ($match_1[0] as $match_2) {
            [$match, $index] = $match_2;

            // Correct offsets for multi-byte characters (`PREG_OFFSET_CAPTURE` returns
            // byte-offset). We fix this by recounting the text before the offset using
            // multi-byte aware `strlen`
            $index = mb_strlen(substr($string, 0, $index));

            $wordLC = $index > 0
                      && mb_substr($string, max(0, $index - 2), 1) !== ':'
                      && preg_match($smallWords, $match);
            $wrappers = preg_match('/[\'"_{(\[‘“]/u', mb_substr($string, max(0, $index - 1), 3));
            $lowerC = preg_match('/[\])}]/', mb_substr($string, max(0, $index - 1), 3))
                      || preg_match('/[A-Z]+|&|\w+[._]\w+/u', mb_substr($match, 1, mb_strlen($match) - 1));

            // Words that must always be lowercase are found (never in the first word, and
            // never if they start with a colon).
            if ($wordLC) {
                // ..and convert them to lowercase
                $match = mb_strtolower($match);

            // Brackets and other wrappers were found
            } elseif ($wrappers) {
                // convert first letter within wrapper to uppercase
                $match = mb_substr($match, 0, 1).
                         mb_strtoupper(mb_substr($match, 1, 1)).
                         mb_substr($match, 2, mb_strlen($match) - 2);

            // Do not uppercase these cases
            } elseif ($lowerC) {
                continue;
            } else {
                // if all else fails, then no more fringe-cases; uppercase the word
                $match = mb_strtoupper(mb_substr($match, 0, 1)).
                         mb_substr($match, 1, mb_strlen($match));
            }

            // Resplice the title with the change
            $string = mb_substr($string, 0, $index).$match.
                      mb_substr($string, $index + mb_strlen($match), mb_strlen($string));
        }

        return $string;
    }
}
