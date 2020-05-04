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
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('clientes', 'ClienteController');
    Route::delete('/clientes_bath','ClienteController@destroyBath' )->name('clientes_bath.destroy');
    Route::resource('produtos', 'ProdutoController');
    Route::delete('/produtos_bath','ProdutoController@destroyBath' )->name('produtos_bath.destroy');
    Route::resource('users', 'UserController');
    Route::delete('/users_bath','UserController@destroyBath' )->name('users_bath.destroy');
   
});
