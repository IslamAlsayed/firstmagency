<?php

namespace IslamAlsayed\Toasts;

class Toast
{
    public static function success($message = null)
    {
        return (new ToastManager)->add('success', $message);
    }

    public static function error($message = null)
    {
        return (new ToastManager)->add('error', $message);
    }

    public static function danger($message = null)
    {
        return (new ToastManager)->add('danger', $message);
    }

    public static function warning($message = null)
    {
        return (new ToastManager)->add('warning', $message);
    }

    public static function info($message = null)
    {
        return (new ToastManager)->add('info', $message);
    }

    public static function confirm($message = null)
    {
        return (new ToastManager)->add('confirm', $message);
    }
}