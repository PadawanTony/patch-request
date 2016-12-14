<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/12/16
 */
use Core\App;
use Core\flash\Flash;

App::bind('config.app', require __DIR__ . '/../../config/app.php');

App::bind('config.database', require __DIR__ . '/../../config/database.php'); //ToDo: Create the DB

App::bind('flash', Flash::class);

if ( ! environment('production'))
{
    App::bind('faker', Faker\Factory::create());
}
