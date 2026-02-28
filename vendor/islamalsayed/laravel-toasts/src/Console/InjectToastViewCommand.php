<?php

namespace IslamAlsayed\Toasts\Console;

use Illuminate\Console\Command;

class InjectToastViewCommand extends Command
{
    protected $signature = 'toasts:inject';
    protected $description = 'Inject toasts snippet, styles, and scripts into layout files.';

    public function handle()
    {
        $masterPath = resource_path('views/layouts/master.blade.php');
        $headPath = resource_path('views/layouts/head.blade.php');
        $footPath = resource_path('views/layouts/foot.blade.php');

        if (!file_exists($masterPath)) {
            $this->warn("master.blade.php not found in layouts folder.");
            return;
        }

        $masterContents = file_get_contents($masterPath);
        $headContents = file_exists($headPath) ? file_get_contents($headPath) : null;
        $footContents = file_exists($footPath) ? file_get_contents($footPath) : null;

        $bladeSnippet = <<<BLADE
            @if (view()->exists('vendor/toasts/toasts'))
                @include('vendor.toasts.toasts')
            @endif
        BLADE;

        $cssSnippet = <<<CSS
        
            {{-- FontAwesome Icons --}}
            <link rel="stylesheet" href="{{ asset('vendor/toasts/css/all.min.css') }}">
            {{-- Toasts Styles --}}
            <link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
        CSS;

        $jsSnippet = <<<JS
            {{-- Toasts Scripts --}}
            <script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>
        JS;

        // Inject Blade snippet into master.blade.php (if not already present)
        if (strpos($masterContents, "@include('vendor.toasts.toasts')") === false) {
            // Use regex to find <head> tag with or without attributes
            if (preg_match('/<body[^>]*>/i', $masterContents, $matches)) {
                $bodyTag = $matches[0];
                $masterContents = preg_replace(
                    '/<body[^>]*>/i',
                    $bodyTag . "\n" . $bladeSnippet . "\n",
                    $masterContents,
                    1
                );
            } else {
                $masterContents .= "\n\n" . $bladeSnippet;
            }
            try {
                file_put_contents($masterPath, $masterContents);
                $this->info("Blade snippet injected into master.blade.php");
            } catch (\Exception $e) {
                $this->error("Failed to inject Blade snippet: " . $e->getMessage());
            }
        } else {
            $this->info("Blade snippet already exists in master.blade.php");
        }

        // === CSS INJECTION ===
        if ($headContents !== null) {
            if (strpos($headContents, '<link rel="stylesheet" href="{{ asset(\'vendor/toasts/css/all.min.css\') }}">') === false) {
                $headContents .= "\n" . $cssSnippet . "\n";
                try {
                    file_put_contents($headPath, $headContents);
                    $this->info("CSS snippet injected into head.blade.php");
                } catch (\Exception $e) {
                    $this->error("Failed to inject CSS snippet: " . $e->getMessage());
                }
            } else {
                $this->info("CSS snippet already exists in head.blade.php");
            }
        } else {
            if (strpos($masterContents, '<link rel="stylesheet" href="{{ asset(\'vendor/toasts/css/all.min.css\') }}">') === false) {
                $masterContents = file_get_contents($masterPath); // reload content
                $masterContents = str_replace('</head>', $cssSnippet . "\n</head>", $masterContents);
                try {
                    file_put_contents($masterPath, $masterContents);
                    $this->info("CSS snippet injected into master.blade.php");
                } catch (\Exception $e) {
                    $this->error("Failed to inject CSS snippet: " . $e->getMessage());
                }
            } else {
                $this->info("CSS snippet already exists in master.blade.php");
            }
        }

        // === JS INJECTION ===
        if ($footContents !== null) {
            if (strpos($footContents, '<script type="module" src="{{ asset(\'vendor/toasts/js/toasts.js\') }}"></script>') === false) {
                $footContents .= "\n" . $jsSnippet . "\n";
                try {
                    file_put_contents($footPath, $footContents);
                    $this->info("JS snippet injected into foot.blade.php");
                } catch (\Exception $e) {
                    $this->error("Failed to inject JS snippet: " . $e->getMessage());
                }
            } else {
                $this->info("JS snippet already exists in foot.blade.php");
            }
        } else {
            if (strpos($masterContents, '<script type="module" src="{{ asset(\'vendor/toasts/js/toasts.js\') }}"></script>') === false) {
                $masterContents = file_get_contents($masterPath); // reload content
                $masterContents = str_replace('</head>', $jsSnippet . "\n</head>", $masterContents);
                try {
                    file_put_contents($masterPath, $masterContents);
                    $this->info("JS snippet injected into master.blade.php");
                } catch (\Exception $e) {
                    $this->error("Failed to inject JS snippet: " . $e->getMessage());
                }
            } else {
                $this->info("JS snippet already exists in master.blade.php");
            }
        }
    }
}