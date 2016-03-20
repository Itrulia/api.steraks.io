<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');

Route::resource('user', 'API\UserController');
Route::group(['prefix' => '/user/{user}'], function () {
    Route::get('following', 'API\UserController@getFollowing');
});

Route::group(['prefix' => '{region}'], function () {
    Route::group(['prefix' => 'match/{matchId}'], function () {
        Route::get('{summonerId}', 'API\MatchController@getMatchForSummoner');
        Route::get('/', 'API\MatchController@getMatch');
    });

    Route::group(['prefix' => 'summoner/{summonerId}'], function () {
        Route::get('/', 'API\SummonerController@getSummoner');
        Route::get('rank', 'API\SummonerController@getRank');
        Route::get('matches', 'API\SummonerController@getMatches');
        Route::get('runes', 'API\SummonerController@getRunes');
        Route::get('masteries', 'API\SummonerController@getMasteries');
        Route::get('stats', 'API\SummonerController@getStats');

        // counter
        Route::get('counters', 'API\SummonerController@counters');
        Route::get('synergy', 'API\SummonerController@synergy');
    });
});

Route::group(['prefix' => '/static'], function () {
    Route::get('rune', 'API\StaticController@getRunes');
    Route::get('mastery', 'API\StaticController@getMasteries');
    Route::get('champion', 'API\StaticController@getChampions');
    Route::get('item', 'API\StaticController@getItems');
    Route::get('summoner-spell', 'API\StaticController@getSummonerSpells');
    Route::get('realm', 'API\StaticController@getRealm');
});

