<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
//Auth
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@handleLogin');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@handleRegister');

Route::get('/index', 'IndexController@index');

Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'member'], function () {
		Route::get('/{member_id}','Member\PageController@index');
		Route::group(['prefix' => '{member_id}'], function () {
			Route::get('/edit','Member\PageController@edit');
			Route::patch('/edit','Member\FunctionController@update');
			Route::group(['prefix' => 'shop'], function () {
				Route::get('/list','Shop\PageController@list');
				Route::get('/create','Shop\PageController@create');
				Route::post('/create','Shop\FunctionController@create');
				Route::group(['prefix' => '{shop_id}'], function () {
					Route::get('/edit','Shop\PageController@edit');
					Route::patch('/edit','Shop\FunctionController@update');
					Route::group(['prefix' => 'productlist'], function () {
						Route::get('/edit','ProductList\PageController@edit');
						Route::patch('/create','ProductList\FunctionController@create');
						Route::group(['prefix' => '{productlist_id}'], function () {
							Route::patch('/update','ProductList\FunctionController@update');
						});
					});
					Route::group(['prefix' => 'product'], function () {
						Route::get('/create','Product\PageController@create');
						Route::post('/create','Product\FunctionController@create');
						Route::group(['prefix' => '{product_id}'], function () {
							Route::get('/edit','Product\PageController@edit');
							Route::patch('/edit','Product\FunctionController@update');
							Route::delete('/edit','Product\FunctionController@delete');
						});
					});
				});
			});
		});
	});
});


Route::get('/test', function () {
    return view('success');
});