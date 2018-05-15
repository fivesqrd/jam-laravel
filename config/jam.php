<?php

return [

    'table' => env('SESSION_TABLE'),
    'lifetime' => env('SESSION_LIFETIME'),
    'aws' => [
        'version' => '2012-08-10',
        'region'  => env('AWS_REGION', 'eu-west-1'),
        'credentials' => [
            'key'    => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
        ],
        'endpoint' => env('AWS_ENDPOINT') ?: null
    ],

];
