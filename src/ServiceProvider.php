<?php

namespace Kabocom\SoftHyphens;

use Statamic\Statamic; // ++-- clear these up
use Illuminate\Support\Facades\View;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../dist/js/soft-hyphens.js',
    ];

    public function register() {
        $this->app->bind(\Statamic\Fieldtypes\Bard::class, Bard::class);
    }

    public function boot() {
        parent::boot();
        //Augmentor::addExtension('soft-hyphens', new Bard());
    }
}
