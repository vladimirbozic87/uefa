<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('get-team');
});

Route::get('/teams', 'TeamController@getCreate')->name('get-team');

Route::post('/teams', 'TeamController@postCreate')->name('post-team');

Route::get('/team/{name}', 'TeamController@getCreatePlayers')->name('get-create-players');

Route::post('/team/{name}', 'TeamController@postCreatePlayers')->name('post-create-players');

Route::get('/set', 'TeamController@getSetTeam')->name('get-set-team');

Route::post('/set', 'TeamController@postSetTeam')->name('post-set-team');

Route::get('/game', 'GameController@getPlayTeam')->name('get-play-game');

Route::get('/formation/{name}', 'GameController@getFormation')->name('get-formation');

Route::post('/formation/{name}', 'GameController@postFormation')->name('post-formation');

Route::post('/play/{game_id}', 'GameController@play')->name('play');
