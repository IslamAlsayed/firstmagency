<?php

if (!function_exists('showToast')) {
    function showToast($type, $message)
    {
        return app('toast')->add($type, $message);
    }
}

if (!function_exists('showToastSuccess')) {
    function showToastSuccess($message)
    {
        return app('toast')->add('success', $message);
    }
}

if (!function_exists('showToastSuccessMessage')) {
    function showToastSuccessMessage($message)
    {
        return app('toast')->add('success', $message, true);
    }
}

if (!function_exists('showToastError')) {
    function showToastError($message)
    {
        return app('toast')->add('error', $message);
    }
}

if (!function_exists('showToastErrorMessage')) {
    function showToastErrorMessage($message)
    {
        return app('toast')->add('error', $message, true);
    }
}

if (!function_exists('showToastDanger')) {
    function showToastDanger($message)
    {
        return app('toast')->add('danger', $message);
    }
}

if (!function_exists('showToastDangerMessage')) {
    function showToastDangerMessage($message)
    {
        return app('toast')->add('danger', $message, true);
    }
}

if (!function_exists('showToastWarning')) {
    function showToastWarning($message)
    {
        return app('toast')->add('warning', $message);
    }
}

if (!function_exists('showToastWarningMessage')) {
    function showToastWarningMessage($message)
    {
        return app('toast')->add('warning', $message, true);
    }
}

if (!function_exists('showToastInfo')) {
    function showToastInfo($message)
    {
        return app('toast')->add('info', $message);
    }
}

if (!function_exists('showToastInfoMessage')) {
    function showToastInfoMessage($message)
    {
        return app('toast')->add('info', $message, true);
    }
}

if (!function_exists('addConfirm')) {
    function addConfirm($message)
    {
        return app('toast')->add('confirm', $message);
    }
}

if (!function_exists('addConfirmSuccess')) {
    function addConfirmSuccess($message)
    {
        return app('toast')->add('confirm', $message)->theme('success');
    }
}

if (!function_exists('addConfirmError')) {
    function addConfirmError($message)
    {
        return app('toast')->add('confirm', $message)->theme('error');
    }
}

if (!function_exists('addConfirmWarning')) {
    function addConfirmWarning($message)
    {
        return app('toast')->add('confirm', $message)->theme('warning');
    }
}

if (!function_exists('addConfirmInfo')) {
    function addConfirmInfo($message)
    {
        return app('toast')->add('confirm', $message)->theme('info');
    }
}

if (!function_exists('getIcon')) {
    function getIcon($type)
    {
        $icons = [
            'success' => 'circle-check',
            'error' => 'circle-xmark',
            'warning' => 'triangle-exclamation',
            'info' => 'circle-exclamation'
        ];

        return isset($icons[$type]) ? $icons[$type] : 'circle-exclamation';
    }
}

if (!function_exists('isEmoji')) {
    function isEmoji($char)
    {
        return preg_match('/[\x{1F600}-\x{1F64F}' . '\x{1F300}-\x{1F5FF}' . '\x{1F680}-\x{1F6FF}' . '\x{2600}-\x{26FF}' . '\x{2700}-\x{27BF}' . '\x{1F900}-\x{1F9FF}' . '\x{1FA70}-\x{1FAFF}]/u', $char);
    }
}

if (!function_exists('isToastArray')) {
    function isToastArray($type, $key)
    {
        if (is_array(session()->get($type)) && isset(session()->get($type)[$key])) {
            return session()->get($type)[$key];
        }

        if ($key == 'message') {
            return session()->get($type);
        }

        return null;
    }
}

if (!function_exists('getToastActions')) {
    function getToastActions($type)
    {
        $data = [];

        if (is_array(session()->get($type)) && isset(session()->get($type)['actions'])) {
            $data = session()->get($type)['actions'];
        }

        if (!$data) {
            return null;
        }

        if (array_key_exists('label', $data) && array_key_exists('url', $data)) {
            return [$data];
        }

        return $data;
    }
}