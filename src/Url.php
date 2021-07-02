<?php

namespace Realodix\Utils;

use Spatie\Url\Url as SpatieUrl;

class Url
{
    /**
     * Display the link according to what You need.
     *
     * @param string $url    URL or Link.
     * @param bool   $scheme Show or remove URL schemes.
     * @param int    $limit  Length string will be truncated to, including
     *                       suffix.
     *
     * @return string
     */
    public static function display(string $url, bool $scheme = true, int $limit = null)
    {
        $sUrl = SpatieUrl::fromString($url);
        $hostLen = strlen($sUrl->getScheme().'://'.$sUrl->getHost());
        $urlLen = strlen($url);
        $limit = is_null($limit) ? $urlLen : $limit;

        // Remove URL schemes
        if (! $scheme) {
            $url = self::sanitize($url);
            $hostLen = strlen($sUrl->getHost());
            $urlLen = strlen($url);
        }

        $pathLen = $limit - $hostLen;

        // If it's only the host and has the trailing slash at the end, then remove the
        // trailing slash.
        if ($pathLen === 1) {
            $url = rtrim($url, '/\\');
        }

        if ($urlLen > $limit) {
            // The length of string truncated by str()->limit() does not include a suffix,
            // so it needs to be adjusted so that the length of the truncated string
            // matches the expected limit.
            $adjLimit = $limit - (strlen(Str::limit($url, $limit)) - $limit);

            $firstSide = $hostLen + intval(($pathLen - 1) * 0.5);
            $lastSide = -abs($adjLimit - $firstSide);

            if (((1 <= $pathLen) && ($pathLen <= 9)) || ($hostLen > $limit)) {
                return Str::limit($url, $adjLimit);
            }

            return Str::limit($url, $firstSide).substr($url, $lastSide);
        }

        return $url;
    }

    /**
     * Remove http://, www., and slashes from the URL.
     *
     * @param string $url
     *
     * @return mixed
     */
    public static function sanitize($url)
    {
        return preg_replace(['{^http(s)?://}', '{www.}', '{/$}'], '', $url);
    }
}
