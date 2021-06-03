<?php

namespace Realodix\Utils\String;

class ReadTime
{
    /**
     * Calculates the time some text takes the average human to read, based on Medium's
     * read time formula. Take the total word count of a post and translate it into
     * minutes.
     *
     * @param int $wpm Estimated words per minute of reader
     * @return string
     */
    public function readTime(string $content, int $wpm = 265): string
    {
        $content = strip_tags($content, '<img>');
        $wordCount = str_word_count($content);
        $imgReadTime = $this->imageReadTime($content, 12);

        $readTime = ($wordCount / $wpm) + $imgReadTime;

        if ($readTime < 0.5) {
            return 'less than a minute';
        }
        if ($readTime >= 0.5 && $readTime < 1.5) {
            return '1 min read';
        }

        return ceil($readTime).' min read';
    }

    /**
     * Calculates the amount of reading time for an image in a post.
     *
     * Read time calculation to count 12 seconds for the first image, 11 for the second,
     * and minus an additional second for each subsequent image. Any images after the
     * tenth image are counted at three seconds.
     *
     * @param string $content
     * @return float
     */
    private function imageReadTime(string $content, int $imgReadTime = 12): float
    {
        $seconds = 0;
        $count = $this->imageCount($content);

        if ($count > 10) {
            $f10Count = 10;
            $p1 = ($f10Count / 2) * (2 * $imgReadTime + (1 - $f10Count));
            $p2 = ($count - $f10Count) * 3;
            $seconds = $p1 + $p2;
        } else {
            // n/2[2a+(n-1)d]
            $seconds = ($count / 2) * (2 * $imgReadTime + (1 - $count));
        }

        return $seconds / 60;
    }

    /**
     * Count the number of images.
     *
     * @param string $content
     * @return int
     */
    private function imageCount(string $content): int
    {
        $pattern = '/<(img)([\W\w]+?)[\/]?>/';

        return preg_match_all($pattern, $content, $matches);
    }
}
