<?php

namespace Fivesqrd\Jam;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Support;
use Aws\DynamoDb;

/**
 * Atlas service provider
 */
class JamServiceProvider extends Support\ServiceProvider
{
    
    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__ . '/../config/jam.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('jam.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('jam');
        }

        $this->mergeConfigFrom($source, 'jam');

        Support\Facades\Session::extend('dynamodb', function($app) {
            $config = $app->make('config')->get('jam');

            $client = new DynamoDb\DynamoDbClient($config['aws']);

            $handler = DynamoDb\SessionHandler::fromClient($client, [
                'table_name'            => $config['table'],
                'hash_key'              => 'id',
                'session_lifetime'      => $config['lifetime'] * 60,
            ]);

            $handler->register();

            return $handler;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
