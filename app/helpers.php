<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('limitedText')) {
    function limitedText($text, $limit, $end = '...'): string
    {
        return \Illuminate\Support\Str::limit($text, $limit, $end);
    }
}

if (!function_exists('checkExistFile')) {
    function checkExistFile(?string $path = null, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }
}

if (!function_exists('checkExistFileInPublic')) {
    function checkExistFileInPublic(?string $path = null): bool
    {
        if (empty($path)) {
            return false;
        }

        $fullPath = public_path('assets/images/' . $path);
        return file_exists($fullPath);
    }
}
