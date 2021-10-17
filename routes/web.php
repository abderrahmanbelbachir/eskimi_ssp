<?php

use App\Http\Controllers\CompaignController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('/compaign', CompaignController::class);

Route::post('/compaigns/filter', [CompaignController::class, 'filter'])
    ->name('compaigns.filter');
Route::post('/compaigns/{compaign}/update', [CompaignController::class, 'update'])
    ->name('compaign.update.post');