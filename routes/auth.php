<?php

use Core\Router;

Router::get('dashboard', 'Auth/DashboardController@index');

/*
|--------------------------------------------------------------------------
| Campaigns
|--------------------------------------------------------------------------
*/
Router::get('campaigns', 'Auth/CampaignsController@index');
Router::get('campaigns/create', 'Auth/CampaignsController@create');
Router::get('campaigns/{campaign_id}/edit', 'Auth/CampaignsController@edit');
Router::post('campaigns/store', 'Auth/CampaignsController@store');
Router::post('campaigns/{campaign_id}/update', 'Auth/CampaignsController@update');

/*
|--------------------------------------------------------------------------
| Campaign Questions
|--------------------------------------------------------------------------
*/
Router::get('campaigns/{campaign_id}/questions', 'Auth/CampaignQuestionsController@index');
Router::get('campaigns/{campaign_id}/questions/create', 'Auth/CampaignQuestionsController@create');
Router::post('campaigns/{campaign_id}/questions/store', 'Auth/CampaignQuestionsController@store');
Router::get('campaigns/{campaign_id}/questions/{question_id}/edit', 'Auth/CampaignQuestionsController@edit');
Router::post('campaigns/{campaign_id}/questions/{question_id}/update', 'Auth/CampaignQuestionsController@update');

/*
|--------------------------------------------------------------------------
| Campaign Responses
|--------------------------------------------------------------------------
*/
Router::get('responses', 'Auth/ResponsesController@index');

/*
|--------------------------------------------------------------------------
| Ngos
|--------------------------------------------------------------------------
*/
Router::get('ngos', 'Auth/NgosController@index');
Router::get('ngos/create', 'Auth/NgosController@create');
Router::get('ngos/{ngo_id}/edit', 'Auth/NgosController@edit');
Router::post('ngos/store', 'Auth/NgosController@store');
Router::post('ngos/{ngo_id}/update', 'Auth/NgosController@update');

/*
|--------------------------------------------------------------------------
| Apps
|--------------------------------------------------------------------------
*/
Router::get('apps', 'Auth/AppsController@index');
Router::get('apps/create', 'Auth/AppsController@create');
Router::get('apps/{app_id}/edit', 'Auth/AppsController@edit');
Router::post('apps/store', 'Auth/AppsController@store');
Router::post('apps/{app_id}/update', 'Auth/AppsController@update');

/*
|--------------------------------------------------------------------------
| Other
|--------------------------------------------------------------------------
*/
Router::get('campaigns/create/default', 'Auth/CampaignsController@createDefault');
Router::get('campaigns/templates/default', 'Auth/CampaignsController@template');
Router::get('campaigns/forms/create', 'Auth/CampaignsController@createForm');
