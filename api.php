<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/allDataAnak', [App\Http\Controllers\ApiController::class, 'allDataAnak']);
Route::get('/allDataDasarAnak', [App\Http\Controllers\ApiController::class, 'allDataDasarAnak']);
Route::get('/showDataDasarAnak/{id}', [App\Http\Controllers\ApiController::class, 'showDataDasarAnak']);
Route::get('/showAllDataAnak/{id}', [App\Http\Controllers\ApiController::class, 'showAllDataAnak']);
Route::get('/get-kec', [App\Http\Controllers\ApiController::class, 'getKecApi']);
Route::get('/get-puskesmas/{id}', [App\Http\Controllers\ApiController::class, 'getPuskesmasApi']);
Route::get('/get-kelurahan/{id}', [App\Http\Controllers\ApiController::class, 'getKelApi']);
Route::get('/get-rt/{id}', [App\Http\Controllers\ApiController::class, 'getRtApi']);
Route::get('/get-posyandu/{id}', [App\Http\Controllers\ApiController::class, 'getPosyanduApi']);

