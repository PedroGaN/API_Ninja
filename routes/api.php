<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NinjaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ninjas')->group(function () {
	Route::post('/new',[NinjaController::class,"newNinja"]);
	Route::post('/edit/{id}',[NinjaController::class,"editNinja"]);
	Route::post('/changeStatus/{id}{newStatus}',[NinjaController::class,"statusChangeNinja"]);
	Route::get('/list',[NinjaController::class,"listNinjas"]);
});

Route::prefix('clients')->group(function () {
	Route::post('/new',[NinjaController::class,"newClient"]);
	Route::post('/edit/{id}',[NinjaController::class,"editClient"]);
	Route::get('/list',[NinjaController::class,"listClients"]);
});