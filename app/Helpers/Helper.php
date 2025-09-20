<?php

if (!function_exists('getYouTubeThumbnail')) {
    function getYouTubeThumbnail($url)
    {
        preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
        return isset($matches[1]) ? "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg" : null;
    }
}
