<?php

declare(strict_types=1);

/*
 * This file is part of the Jira SDK Laravel project.
 *
 * (c) Nick Haynes (https://github.com/nhaynes)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JiraSdk\Laravel;

use Illuminate\Support\ServiceProvider;
use JiraSdk\Client;
use JiraSdk\ClientFactory;

/**
 * AWS SDK for PHP service provider for Laravel applications.
 */
class JiraServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the configuration.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . '/../config/jira.php' => config_path('jira.php')],
                'jira-config'
            );
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/jira.php',
            'jira'
        );

        $this->app->singleton('jira', function ($app) {
            $config = $app->make('config')->get('jira');

            return ClientFactory::create(
                $config['sitename'],
                $config['credentials']['username'],
                $config['credentials']['token']
            );
        });

        $this->app->alias('jira', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['jira', Client::class];
    }
}
