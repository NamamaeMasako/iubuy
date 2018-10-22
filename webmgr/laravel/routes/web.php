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

//Auth
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@handleLogin');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/register', 'Auth\RegisterController@register');
Route::post('/register', 'Auth\RegisterController@handleRegister');

Route::group(['middleware' => ['auth']], function () {
	//總覽
	Route::get('/', function(){
		return redirect('/dashbroad');
	});
	Route::get('/dashbroad','Index\PageController@index')->middleware('SignPost');
	//管理中心
	Route::group(['prefix' => 'users'], function () {
		//頁面
		Route::get('/', 'Users\PageController@index')->middleware('SignPost');
		Route::get('/create', 'Users\PageController@create')->middleware('IdentityCheck');
		Route::get('/edit/{id}', 'Users\PageController@edit')->middleware('IdentityCheck');
		//功能
		Route::post('/create', 'Users\FunctionController@create')->middleware('IdentityCheck');
		Route::patch('/edit/{id}', 'Users\FunctionController@update')->middleware('IdentityCheck');
		Route::delete('/delete/{id}', 'Users\FunctionController@delete')->middleware('IdentityCheck');
		Route::get('/search', 'Users\FunctionController@search');
		Route::get('/clearsearch', 'Users\FunctionController@clearsearch');
	});
	//會員中心
	Route::group(['prefix' => 'members'], function () {
		//頁面
		Route::get('/', 'Members\PageController@index')->middleware('SignPost');
		Route::get('/edit/{id}', 'Members\PageController@edit')->middleware('SignPost');
		//功能
		Route::patch('/edit/{id}', 'Members\FunctionController@update');
		Route::delete('/delete/{id}', 'Members\FunctionController@delete')->middleware('IdentityCheck');
		Route::get('/search', 'Members\FunctionController@search');
		Route::get('/clearsearch', 'Members\FunctionController@clearsearch');
	});
	//商家中心
	Route::group(['prefix' => 'shops'], function () {
		//頁面
		Route::get('/', 'Shops\PageController@index')->middleware('SignPost');
		Route::get('/edit/{id}', 'Shops\PageController@edit');
		//功能
		Route::patch('/edit/{id}', 'Shops\FunctionController@update');
		Route::delete('/delete/{id}', 'Shops\FunctionController@delete')->middleware('IdentityCheck');
		Route::get('/search', 'Shops\FunctionController@search');
		Route::get('/clearsearch', 'Shops\FunctionController@clearsearch');
	});
	//商家中心
	Route::group(['prefix' => 'products'], function () {
		//頁面
		Route::get('/', 'Products\PageController@index')->middleware('SignPost');
		Route::get('/edit/{id}', 'Products\PageController@edit');
		//功能
		Route::patch('/edit/{id}', 'Products\FunctionController@update');
		Route::delete('/delete/{id}', 'Products\FunctionController@delete')->middleware('IdentityCheck');
		Route::get('/search', 'Products\FunctionController@search');
		Route::get('/clearsearch', 'Products\FunctionController@clearsearch');
	});
});
