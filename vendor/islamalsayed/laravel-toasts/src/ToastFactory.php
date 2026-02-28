<?php

namespace IslamAlsayed\Toasts;

class ToastFactory
{
    public $type;
    public $message;
    public $messageMode;
    public $title = null;
    public $emoji = null;
    public $icon = null;
    public $duration = null;
    public $position = null;
    public $pin = null;
    public $theme = null;
    public $dir = null;
    public $onconfirm = null;
    public $link = null;
    public $target = null;
    public $oncancel = null;
    public $actions = [];

    public function __construct($type, $message = null, $messageMode)
    {
        $this->type = $type;
        $this->message = $message ?: config('toasts.default_message', 'default message');
        $this->title = $messageMode == true ? '' : ($type ?: config('toasts.default_title', 'default title'));
        // $this->defaultMessageType = $defaultMessageType;
        $this->position = config('toasts.default_position', 'top');
        $this->onconfirm = config('toasts.default_onconfirm_text', 'Yes');
        $this->oncancel = config('toasts.default_oncancel_text', 'No');
    }

    public function title($title = null)
    {
        $this->title = $title ?: match ($this->type) {
            'confirm' => config('toasts.default_confirm_title', 'you are sure?'),
            default => config('toasts.default_title', 'default title'),
        };
        return $this;
    }

    public function emoji(string $emoji): self
    {
        $this->emoji = $emoji;
        $this->icon = null; // Disable default icon if emoji is present
        return $this;
    }

    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getIcon()
    {
        return $this->icon ?: match ($this->type) {
            'success' => 'circle-check',
            'error' => 'xmark',
            'danger' => 'circle-xmark',
            'warning' => 'triangle-exclamation',
            'info' => 'circle-exclamation',
            default => 'bell',
        };
    }

    public function duration($milliseconds)
    {
        $this->duration = $milliseconds;
        return $this;
    }

    public function position($position = null)
    {
        if (function_exists('config')) {
            $this->position = $position ?: config('toasts.default_position', 'top');
        } else {
            $this->position = $position ?: 'top';
        }
        return $this;
    }

    public function pin()
    {
        $this->pin = 'pin';
        return $this;
    }

    public function withAction($label, $url)
    {
        $this->actions[] = ['label' => $label, 'url' => $url];
        return $this;
    }

    public function theme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTheme()
    {
        return $this->theme ?: match ($this->type) {
            'success' => 'success',
            'error' => 'error',
            'danger' => 'danger',
            'warning' => 'warning',
            'info' => 'info',
            default => function_exists('config') ? config('toasts.default_theme') : null,
        };
    }

    public function dir($dir = 'ltr')
    {
        if (function_exists('config')) {
            $this->dir = $dir ?: config('toasts.default_dir', 'ltr');
        } else {
            $this->dir = $dir ?: 'ltr';
        }
        return $this;
    }

    public function onConfirm($onconfirm = null)
    {
        if (function_exists('config')) {
            $this->onconfirm = $onconfirm ?: config('toasts.default_onconfirm_text', 'Yes');
        } else {
            $this->onconfirm = $onconfirm ?: 'Yes';
        }
        return $this;
    }

    public function link($link = '/')
    {
        $this->link = $link;
        return $this;
    }

    public function target($target = null)
    {
        $this->target = $target;
        return $this;
    }

    public function onCancel($oncancel = null)
    {
        if (function_exists('config')) {
            $this->oncancel = $oncancel ?: config('toasts.default_oncancel_text', 'No');
        } else {
            $this->oncancel = $oncancel ?: 'No';
        }
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'emoji' => $this->emoji,
            'icon' => $this->icon,
            'duration' => $this->duration,
            'position' => $this->position,
            'pin' => $this->pin,
            'theme' => $this->theme,
            'dir' => $this->dir,
            'onconfirm' => $this->onconfirm,
            'link' => $this->link,
            'target' => $this->target,
            'oncancel' => $this->oncancel,
            'actions' => $this->actions,
        ];
    }
}