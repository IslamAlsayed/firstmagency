<?php

use App\Models\Section;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('getActiveUser')) {
    /**
     * Get the currently authenticated user or a user by ID.
     * Checks authentication first.
     *
     * @param int|null $id
     * @return \Modules\Core\Entities\User|null
     */
    function getActiveUser($id = null)
    {
        if (!Auth::check()) {
            return null;
        }

        if ($id != null) {
            return User::find($id) ?? null;
        }

        return Auth::user();
    }
}

if (!function_exists('getActiveUserId')) {
    /**
     * Get the currently authenticated user's ID.
     * Checks authentication first.
     *
     * @param int|null $id
     * @return \Modules\Core\Entities\User|null
     */
    function getActiveUserId($id = null)
    {
        if (!Auth::check()) {
            return null;
        }

        if ($id != null) {
            $user = User::find($id);
            return $user ? $user->id : null;
        }

        return Auth::id();
    }
}


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

// تحقق من كون الراوت الحالي هو الراوت المحدد مع إمكانية التحقق من البراميترز
if (!function_exists('isActive')) {
    function isActive(?string $route, array $menuParameters = [], ?string $currentRoute = null, array $currentParameters = [])
    {
        if (!$route || $route !== $currentRoute) {
            return false;
        }

        // لو المينيو مفيهوش parameters → route match يكفي
        if (empty($menuParameters)) {
            return true;
        }

        // parameters الحالية (route + query)
        $requestParams = array_merge(request()->route()?->parameters() ?? [], request()->query() ?? []);

        foreach ($menuParameters as $key => $value) {
            // تجاهل أي key رقمي (زي Str::random)
            if (is_int($key)) {
                continue;
            }

            // لو المينيو متوقع parameter مش موجود في الطلب → تجاهله
            if (!array_key_exists($key, $requestParams)) {
                continue;
            }

            // لو موجود بس القيمة مختلفة → مش active
            if ((string) $requestParams[$key] !== (string) $value) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('isActiveRoute')) {
    function isActiveRoute($routeName, $currentRoute)
    {
        return isset($routeName) && $routeName === $currentRoute;
    }
}

// تحقق من وجود راوت نشط بين الأطفال
if (!function_exists('hasActiveChild')) {
    function hasActiveChild(array $children, ?string $currentRoute, array $currentParameters)
    {
        foreach ($children as $child) {
            if (isActive($child['route'] ?? null, $child['parameters'] ?? [], $currentRoute, $currentParameters)) {
                return true;
            }

            if (
                isset($child['children']) &&
                hasActiveChild($child['children'], $currentRoute, $currentParameters)
            ) {
                return true;
            }
        }

        return false;
    }
}

// ارجاع الاسم مفرد مفصول بشرطة
if (!function_exists('singularLowerCaseName')) {
    function singularLowerCaseName(?string $models, string $glue = '-')
    {
        if (!$models)
            return null;

        return implode($glue, array_map(
            fn($item) => Str::lower(Str::singular($item)),
            preg_split('/[.\-_]/', $models)
        ));
    }
}

/* Removed invalid anonymous function definition that caused a syntax error */
if (!function_exists('pluralLowerCaseName')) {
    function pluralLowerCaseName(?string $models, string $type = '-')
    {
        return implode($type, array_map([Str::class, 'lower'], array_map([Str::class, 'plural'], explode($type, $models))));
    }
}

if (!function_exists('hasDisplayableRichText')) {
    /**
     * Check if a record has displayable content in a specific column
     *
     * @return bool
     */
    function hasDisplayableRichText($record = null, string $column = 'description'): bool
    {
        if (! $record || ! isset($record->$column)) {
            return false;
        }

        $body = $record->$column->body ?? '';

        // شيل HTML
        $text = strip_tags($body);

        // شيل &nbsp; والمسافات الغير مرئية
        $text = preg_replace('/\xc2\xa0|\s+/u', '', $text);

        return $text !== '';
    }
}

/**
 * Check if debug mode is enabled for the current IP
 */
if (!function_exists('isDebugModeEnabled')) {
    function isDebugModeEnabled(): bool
    {
        static $debugMode = null;

        if ($debugMode === null) {
            $settings = Setting::first();

            // Check if debug mode is globally enabled
            if (!$settings || !$settings->debug_mode) {
                $debugMode = false;
                return $debugMode;
            }

            // If debug mode is enabled, check if current IP is allowed
            $clientIp = request()->ip();
            $allowedIps = $settings->debug_ips ? json_decode($settings->debug_ips, true) : [];

            // If no IPs specified, allow for everyone (backward compatibility)
            if (empty($allowedIps)) {
                $debugMode = true;
            } else {
                $debugMode = in_array($clientIp, $allowedIps);
            }
        }

        return $debugMode;
    }
}

/**
 * Get current client IP address
 */
if (!function_exists('getCurrentClientIp')) {
    function getCurrentClientIp(): string
    {
        return request()->ip();
    }
}

/**
 * Get a section by flag
 */
if (!function_exists('getSectionByFlag')) {
    function getSectionByFlag($flag)
    {
        return Section::findByFlag($flag);
    }
}

/**
 * Get all sections
 */
if (!function_exists('getAllSections')) {
    function getAllSections()
    {
        return Section::active()->get();
    }
}
