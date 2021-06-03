<?php

namespace Realodix\Utils\String;

class ReadTime
{
    /**
     * Calculate the estimated reading time in seconds for a given piece of content.
     *
     * @param int $wpm Estimated words per minute of reader
     *
     * @return string|empty
     */
    public function readTime(string $content, int $wpm = 265): string
    {
        $content = strip_tags($content, '<img>');
        $wordCount = str_word_count($content);
        $imgReadTime = $this->readTimeImage($content, 12);

        $readTime = ($wordCount / $wpm) + $imgReadTime;

        if ($readTime < 0.5) {
            return 'less than a minute';
        }
        if ($readTime >= 0.5 && $readTime < 1.5) {
            return '1 min read';
        }

        return ceil($readTime).' min read';
    }

    private function readTimeImage($content, int $imgReadTime = 12)
    {
        $seconds = 0;
        $count = $this->readTimeImageCount($content);

        if ($count > 10) {
            $f10Count = 10;
            $p1 = ($f10Count / 2) * (2 * $imgReadTime + (1 - $f10Count));
            $p2 = ($count - $f10Count) * 3;
            $seconds = $p1 + $p2;
        } else {
            $seconds = ($count / 2) * (2 * $imgReadTime + (1 - $count)); // n/2[2a+(n-1)d]
        }

        return $seconds / 60;
    }

    private function readTimeImageCount($content)
    {
        $pattern = '/<(img)([\W\w]+?)[\/]?>/';

        return preg_match_all($pattern, $content, $matches);
    }
}
