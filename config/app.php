<?php

return [
    'env'           => env('APP_ENV', 'production'),
    'debug'         => boolval(env('APP_DEBUG', false)),
    'timezone'      => 'Europe/Athens',
    'storage.cache' => boolval(env('APP_CACHE', true)) ? __DIR__ . '/../storage/framework/cache/twig' : false,
];
