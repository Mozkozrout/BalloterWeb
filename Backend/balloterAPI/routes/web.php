<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', ['uses' => 'AuthController@login']);
	$router->get('logout', ['uses' => 'AuthController@logout']);
    $router->post('register', ['uses' => 'AuthController@register']);
    #$router->get('user/{id}', ['uses' => 'AuthController@showOne']);
    $router->get('user', ['uses' => 'AuthController@returnUser']);
    $router->delete('user/{id}', ['uses' => 'AuthController@delete']);

    $router->post('ballot', ['uses' => 'BallotController@create']);
    $router->get('ballot/pdf/{id}', ['uses' => 'BallotController@createPDF']);
    $router->get('ballots', ['uses' => 'BallotController@showAll']);
    $router->get('ballot', ['uses' => 'BallotController@showMine']);
    $router->get('ballot/{id}', ['uses' => 'BallotController@showOne']);
    $router->delete('ballot/{id}', ['uses' => 'BallotController@delete']);
    $router->put('ballot/{id}', ['uses' => 'BallotController@update']);

    $router->get('teams', ['uses' => 'BallotController@returnTeams']);
    $router->get('tournaments', ['uses' => 'BallotController@returnTournaments']);

    $router->post('motion', ['uses' => 'MotionController@create']);
    $router->get('motion', ['uses' => 'MotionController@showAll']);
    $router->get('motion/{id}', ['uses' => 'MotionController@showOne']);
    $router->delete('motion/{id}', ['uses' => 'MotionController@delete']);
    $router->put('motion/{id}', ['uses' => 'MotionController@update']);

    $router->post('person', ['uses' => 'PersonController@create']);
    $router->delete('person/{id}', ['uses' => 'PersonController@delete']);
    $router->put('person/{id}', ['uses' => 'PersonController@update']);
    $router->get('institutions', ['uses' => 'PersonController@returnInstitutions']);
});
