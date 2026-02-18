<?php

if (!function_exists('limitedText')) {
    function limitedText($text, $limit, $end = '...'): string
    {
        return \Illuminate\Support\Str::limit($text, $limit, $end);
    }
}