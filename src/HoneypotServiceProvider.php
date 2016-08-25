<?php

namespace Codenexus\Honeypot;

use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton('honeypot', function () {
            return new Honeypot;
        });
    }
}