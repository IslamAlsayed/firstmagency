<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait AblyService
{
    public function publishToAbly($channelName, $eventName, $data)
    {
        $ablyKey = config('app.ably_key');
        if (!$ablyKey) {
            Log::error('Ably key is not configured.');
            return;
        }
        try {
            $ably = new \Ably\AblyRest($ablyKey);
            $ably->channel($channelName)->publish($eventName, $data);
        } catch (\Exception $e) {
            Log::error('Failed to publish to Ably: ' . $e->getMessage());
        }
    }
}
