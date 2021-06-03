<?php

namespace Realodix\Utils\String;

class ChangeCase
{
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

        $result = str(mb_strtolower(
            preg_replace($stripRegexp, $delimiter,
                preg_replace($splitRegexp, '$1 $2', $text)
            )
        ));

        // Trim the delimiter from around the output string.
        $start = 0;
        $end = mb_strlen($result);
        while ($result->charAt($start) === $delimiter) {
            $start++;
        }
        while ($result->charAt($end - 1) === $delimiter) {
            $end--;
        }

        // Transform each token independently.
        return implode($delimiter,
            explode($delimiter, $result->slice($start, $end))
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
    public function dotCase(string $string): string
    {
        return self::noCase($string, '.');
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
    public static function titleCase(string $string): string
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
