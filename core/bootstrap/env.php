<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/12/16
 */

use Dotenv\Dotenv;

$dotenv = new Dotenv($path = __DIR__ . '/../..');

if (file_exists($path . '/.env')) // On dev environment
{
    $dotenv->load();
}

$dotenv->required([
    'APP_ENV',
    'DB_NAME',
    'DB_USERNAME',
    'DB_PASSWORD',
])->notEmpty();
