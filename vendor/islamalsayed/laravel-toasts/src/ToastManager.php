<?php

namespace IslamAlsayed\Toasts;

class ToastManager
{
    public function add(string $type, string $message = null, bool $messageMode = false)
    {
        $toast = new ToastFactory($type, $message, $messageMode);
        $toasts = session()->get('toasts', []);
        $toasts[] = $toast;
        session()->flash('toasts', $toasts);
        return $toast;
    }
}