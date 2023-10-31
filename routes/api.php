<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/form-submit',[ApiController::class,'form_submit']);
Route::get('/display-form-data',[ApiController::class,'display']);
Route::get('delete-data/{id}',[ApiController::class,'delete_data']);
Route::get('fetchdata/{id}',[ApiController::class,'fetchdata']);
Route::put('edit-data/{id}',[ApiController::class,'edit_data']);
