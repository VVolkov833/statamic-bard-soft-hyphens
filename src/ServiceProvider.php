<?php

namespace Kabocom\SoftHyphens;

use Statamic\Fieldtypes\Bard;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    // Add Bard button
    protected $scripts = [
        __DIR__.'/../dist/js/soft-hyphens.js',
    ];

    public function boot()
    {
        parent::boot();

        // Use resolving to attach hooks to the current Bard implementation
        $this->app->resolving(\Statamic\Fieldtypes\Bard::class, function ($bard) {

            $bard::hook('process', function ($payload, $next) {  // Modify before saving
                $payload = ServiceProvider::replaceSoftHyphens($payload, '↵', '­');
                return $next($payload);
            });

            $bard::hook('pre-process', function ($payload, $next) { // Modify before rendering in editor
                $payload = ServiceProvider::replaceSoftHyphens($payload, '­', '↵');
                return $next($payload);
            });

        });
    }

    public static function replaceSoftHyphens($value, $search, $replace)
    {
        if (!is_array($value)) {
            return $value;
        }

        return collect($value)->map(function ($item) use ($search, $replace) {
            if (isset($item['text'])) {
                $item['text'] = str_replace($search, $replace, $item['text']);
            }
            if (isset($item['content']) && is_array($item['content'])) {
                $item['content'] = self::replaceSoftHyphens($item['content'], $search, $replace);
            }
            return $item;
        })->all();
       
    }
}
