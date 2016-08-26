<?php

namespace Codenexus\Honeypot;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {
    	$this->loadTranslationsFrom(__DIR__ . '/../lang', 'honeypot');

    	Validator::extend('honeypot', 'honeypot@validateHoneypot', trans('validation.honeypot'));
    	Validator::extend('honeytime', 'honeypot@validateHoneytime', trans('validation.honeytime'));
    }

    public function register()
    {
        $this->app->singleton('honeypot', function () {
            return new Honeypot;
        });
    }

    public function provides()
    {
    	return array('honeypot');
    }
}