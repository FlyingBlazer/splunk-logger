<?php

namespace SplunkLogger;

use Illuminate\Support\ServiceProvider;

class SplunkLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Splunk', function() {
            return new Logger();
        });
    }
}
