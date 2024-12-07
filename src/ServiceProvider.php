<?php

namespace Kabocom\SoftHyphens;

use Statamic\Fieldtypes\Bard;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../dist/js/soft-hyphens.js',
    ];

    public function boot()
    {
        parent::boot();

        Bard::hook('process', function ($payload, $next) {
            $payload = ServiceProvider::replaceSoftHyphens($payload, '↵', '­'); // Modify before saving
            return $next($payload);
        });

        Bard::hook('pre-process', function ($payload, $next) {
            $payload = ServiceProvider::replaceSoftHyphens($payload, '­', '↵'); // Modify before rendering in editor
            return $next($payload);
        });
    }

    public static function replaceSoftHyphens($value, $search, $replace)
    {
        if (is_array($value)) {
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
        return $value;
    }
}
