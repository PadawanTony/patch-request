<?php

return [
	'type'  => env('DB_TYPE', 'mysql'),
	'mysql' => [
		'connection' => 'mysql:host='.env('DB_HOST', 'localhost'),
		'dbname'     => env('DB_NAME'),
		'username'   => env('DB_USERNAME'),
		'password'   => env('DB_PASSWORD'),
		'port'       => env('DB_PORT', '3306'),
		'charset'    => env('DB_CHARSET', 'utf8'),
		'options'    => [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Important to notify users of failed database requests.
		],
	],
];