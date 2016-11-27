<?php

use Core\Router;

/*
|--------------------------------------------------------------------------
| Campaigns Generator
|--------------------------------------------------------------------------
|
| Use 'c' for tiny links. 'c' stands for campaigns
|
*/
Router::get('c', 'CampaignsController@create');
Router::post('c', 'CampaignsController@store');


/*
|--------------------------------------------------------------------------
| Marketing
|--------------------------------------------------------------------------
*/
Router::get('', 'Guest/MarketingController@show');

/*
|--------------------------------------------------------------------------
| Authentication / Registrations
|--------------------------------------------------------------------------
*/
Router::get('login', 'Guest/SessionsController@create');
Router::post('login', 'Guest/SessionsController@store');
Router::post('logout', 'Guest/SessionsController@delete');
Router::get('register', 'Guest/RegistrationsController@create');
Router::post('register', 'Guest/RegistrationsController@store');

/*
|--------------------------------------------------------------------------
| To be deleted asap
|--------------------------------------------------------------------------
*/
Router::post('test-form', 'Guest/MarketingController@testForm');
