<?php

use App\Http\Controllers\ApiFundController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(APiFundController::class)->group(function () {
    Route::post('funds', 'createFund');
    Route::put('/funds/{id}',  'updateFund');

});
