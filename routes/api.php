<?php

use Illuminate\Http\Request;

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


Route::post('/photos', [\App\Http\Controllers\PixabayController::class, 'photos']);
Route::post('/save', [\App\Http\Controllers\PixabayController::class, 'save']);
Route::get('/saved', [\App\Http\Controllers\PixabayController::class, 'saved']);
