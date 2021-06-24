<?php

/**
 * Strips HTML tags, and shortens string lengths, appended by '...'
 * @param  string  $content
 * @param  int     $limit
 * @return string
 */
if (! function_exists('stripHtmlAndShorten')) {
    function stripHtmlAndShorten(string $content, int $limit = 100)
    {
        // Strip HTML tags
        $content = strip_tags($content);

        // Shorten content
        if (strlen($content) > $limit) {
            $content = substr($content, 0, $limit) . '...';
        }
        
        return $content;
    }
}