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
    Route::post('/changeStatus/{id}',[NinjaController::class,"changeNinjaStatus"]);
    Route::get('/filter/{filter}/{value}',[NinjaController::class,"listNinjasFiltered"]);
    Route::get('/list',[NinjaController::class,"listNinjas"]);
    Route::get('/check/{id}',[NinjaController::class,"checkNinja"]);
});

Route::prefix('clients')->group(function () {
	Route::post('/new',[ClientController::class,"newClient"]);
	Route::post('/edit/{id}',[ClientController::class,"editClient"]);
    Route::get('/list',[ClientController::class,"listClients"]);
    Route::get('/check/{id}',[ClientController::class,"checkClient"]);
});

Route::prefix('missions')->group(function () {
	Route::post('/new',[MissionController::class,"newMission"]);
	Route::post('/edit/{id}',[MissionController::class,"editMission"]);
    Route::post('/changeStatus/{id}',[MissionController::class,"changeMissionStatus"]);
    Route::get('/filter/{filter}/{value}',[MissionController::class,"listMissionsFiltered"]);
    Route::get('/list',[MissionController::class,"listMissions"]);
    Route::get('/check/{id}',[MissionController::class,"checkMission"]);
});