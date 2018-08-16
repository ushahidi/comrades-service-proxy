<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/yodie/annotate', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'YodieController@annotate']);

$app->post('/crees/all', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'CreesController@all']);
$app->post('/crees/eventRelated', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'CreesController@eventRelated']);
$app->post('/crees/eventType', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'CreesController@eventType']);
$app->post('/crees/infoType', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'CreesController@infoType']);

$app->post('/actionability/annotate', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'ActionabilityController@annotate']);