<?php

use Core\Router;

/*
|--------------------------------------------------------------------------
| General
|--------------------------------------------------------------------------
|
| Use 'c' for tiny links. 'c' stands for campaigns
|
*/
Router::get('/', 'GeneralController@index');


/*
|--------------------------------------------------------------------------
| Authentication / Registrations
|--------------------------------------------------------------------------
*/
//Router::get('login', 'Guest/SessionsController@create');
//Router::post('login', 'Guest/SessionsController@store');
//Router::post('logout', 'Guest/SessionsController@delete');
//Router::get('register', 'Guest/RegistrationsController@create');
//Router::post('register', 'Guest/RegistrationsController@store');
