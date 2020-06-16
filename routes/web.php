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
    
    Route::resource('rents', 'RentController');
    Route::delete('/rents_bath','RentController@destroyBath' )->name('rents_bath.destroy');
    Route::get('rents/{rent}/print ','RentController@print')->name('rents.print');
    Route::patch('rents/{rent}/quitar', 'RentController@quitar');
    Route::patch('rents/{rent}/desquitar', 'RentController@desquitar');
    Route::get('rents/{rent}/detailAjax ','RentController@detailAjax')->name('rents.detailAjax');

    Route::resource('vendas', 'VendaController');
    Route::delete('/vendas_bath','VendaController@destroyBath' )->name('vendas_bath.destroy');
    Route::get('vendas/{venda}/print ','VendaController@print')->name('vendas.print');
    Route::get('vendas/{venda}/detailAjax ','VendaController@detailAjax')->name('vendas.detailAjax');

    
    Route::get('users/changePassword','UserController@showChangePassword')->name('users.change');
    Route::post('users/changePassword','UserController@updatePassword')->name('users.updatePass');
    Route::resource('users', 'UserController');
    Route::delete('/users_bath','UserController@destroyBath' )->name('users_bath.destroy');

    

});
