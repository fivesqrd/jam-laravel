<?php

namespace Atlas\Laravel;

use Atlas;
use Illuminate\Support;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Atlas service provider
 */
class ServiceProvider extends Support\ServiceProvider
{
    
    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        /* Path to default config file */
        $this->publishes([
            dirname(__DIR__) . '/config/jam.php' => config_path('jam.php')
        ]);

        Session::extend('jam', function($app) {
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