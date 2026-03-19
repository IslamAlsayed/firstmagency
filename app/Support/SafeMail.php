<?php

namespace App\Support;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SafeMail
{
    public static function send(string $to, Mailable $mailable, array $context = []): bool
    {
        $blockedRecipients = config('mail.blocked_recipients', []);

        if (in_array(strtolower($to), array_map('strtolower', $blockedRecipients), true)) {
            Log::info('Skipped sending email to blocked recipient.', array_merge($context, [
                'to' => $to,
                'mailable' => get_class($mailable),
            ]));

            return false;
        }

        try {
            Mail::to($to)->send($mailable);
            return true;
        } catch (\Throwable $e) {
            Log::warning('Mail sending failed but request will continue.', array_merge($context, [
                'to' => $to,
                'mailable' => get_class($mailable),
                'error' => $e->getMessage(),
            ]));

            return false;
        }
    }
}
