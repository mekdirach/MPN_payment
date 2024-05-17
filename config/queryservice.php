<?php



return [
    'host' => env('QUERY_SERVICE_HOST'),
    'port' => env('QUERY_SERVICE_PORT'),
    'pan' => '11000',
    'timeout' => (int) env('QUERY_SERVICE_TIMEOUT'),
    'encrypt_key' => env('ENCRYPTION_KEY'),

];
