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

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Request;

$router->group(['middleware' => 'cors'], function () use ($router){
//    CORS
    $router->options('/{any:.*}', function () use ($router) {
    });

    //запросы с авторизацией
    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('statuses', 'UserController@statuses');
            $router->get('masters', 'UserController@masters');
            $router->post('set-status', 'UserController@setStatus');
            $router->get('status', 'UserController@getStatus');
        });

        $router->group(['prefix' => 'order'], function () use ($router) {
            $router->get('list', 'OrderController@list');
            $router->get('statuses', 'OrderController@statuses');
            $router->get('current-user', 'OrderController@currentUser');
            $router->get('current-user-history', 'OrderController@currentUserHistory');
            $router->post('update', 'OrderController@update');
            $router->post('add-comment', 'OrderController@addComment');
        });
    });

    //запросы без авторизации
    $router->post('login', 'Controller@login');

    $router->group(['prefix' => 'issue'], function () use ($router) {
        $router->get('list', 'IssuesController@list');
    });

    $router->group(['prefix' => 'dadata'], function () use ($router) {
        $router->get('suggestions', 'DadataController@suggestions');
    });

    $router->group(['prefix' => 'order'], function () use ($router) {
        $router->post('create', 'OrderController@create');
    });
});

