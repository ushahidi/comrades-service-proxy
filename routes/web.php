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

$app->post('/annotate', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'AnnotationController@annotate']);

$app->post('/crees/eventRelated', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'creesController@eventRelated']);
$app->post('/crees/eventType', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'creesController@eventType']);
$app->post('/crees/infoType', ['middleware' => 'UshahidiRequestValidator', 'uses' => 'creesController@infoType']);
