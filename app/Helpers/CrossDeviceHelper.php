<?php

namespace App\Helpers;

/**
 * Cross-Device & Multi-Domain Helper Functions
 * 
 * Provides dynamic URL generation for cross-device consistency
 */
class CrossDeviceHelper
{
    /**
     * Get dynamic purchase link for packages
     * Adapts to current environment: production, staging, or local
     * 
     * @param string $packageId Package ID (e.g., 'stdf-at-mshtrk-at')
     * @param string $productId Product ID (e.g., 'bq-at-stdf-at-lml')
     * @return string Full purchase URL
     */
    public static function getPurchaseLink($packageId = 'stdf-at-mshtrk-at', $productId = 'bq-at-stdf-at-lml')
    {
        $portalUrl = config('app.client_portal_url', 'https://client.firstmagency.com');
        
        return "{$portalUrl}/store/{$packageId}/{$productId}";
    }

    /**
     * Get dynamic support image URL
     * Falls back to local assets if remote images unavailable
     * 
     * @param string $type Image type (logo, sales, tickets, phone, account)
     * @return string Image URL
     */
    public static function getSupportImage($type = 'sales')
    {
        $images = config('app.support_images', [
            'logo' => asset('assets/images/White-logo.png'),
            'sales' => asset('assets/images/support/sales.png'),
            'tickets' => asset('assets/images/support/tickets.png'),
            'phone' => asset('assets/images/support/phone.png'),
            'account' => asset('assets/images/support/account.png'),
        ]);

        return $images[$type] ?? asset('assets/images/support/' . $type . '.png');
    }

    /**
     * Get current domain without protocol
     * Useful for cache key generation
     * 
     * @return string Domain name
     */
    public static function getCurrentDomain()
    {
        return request()->getHost();
    }

    /**
     * Get current scheme (http/https)
     * 
     * @return string Scheme
     */
    public static function getCurrentScheme()
    {
        return request()->getScheme();
    }

    /**
     * Generate cache-safe key that includes domain and scheme
     * Prevents cross-device cache collisions
     * 
     * @param string $baseKey Base cache key
     * @return string Domain-aware cache key
     */
    public static function getCacheSafeKey($baseKey)
    {
        $domain = self::getCurrentDomain();
        $scheme = self::getCurrentScheme();
        
        return "{$baseKey}_{$scheme}_{$domain}";
    }
}
