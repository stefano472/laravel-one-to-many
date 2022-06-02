<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Rotta per l'autenticazione gestita giá da larvarel
// una volta che ho registrato l'amministratore posso disattivare alcune rotte
// necessarie per registrazione e recupero password, in modo da rendere il sito meno 
// hackerabile
Auth::routes(['register' => false, 'reset'=>false, 'verify'=> false]);

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::get('/', 'HomeController@index')->name('index');
        Route::resource('/posts', 'PostController');
    });

Route::get('{any}', function(){
    return view('guests.home');
})->where('any', '.*');