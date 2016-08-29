<?php

namespace Codenexus\Honeypot;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$this->loadTranslationsFrom(__DIR__ . '/../lang', 'honeypot');

    	// Add honeypot and honeytime custom validation rules
    	Validator::extend('honeypot', 'honeypot@validateHoneypot', trans('honeypot::validation.honeypot'));
    	Validator::extend('honeytime', 'honeypot@validateHoneytime', trans('honeypot::validation.honeytime'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('honeypot', function () {
            return new Honeypot;
        });
    }
}