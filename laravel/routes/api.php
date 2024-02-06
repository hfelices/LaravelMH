<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PlaceController;
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

Route::middleware('auth:sanctum')->post('/logout', [TokenController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [TokenController::class, 'user']);
Route::middleware('guest')->post('/register',  [TokenController::class, 'register']);
Route::middleware('guest')->post('/login',  [TokenController::class, 'login']);

Route::apiResource('files', FileController::class);
Route::apiResource('places', PlaceController::class);
Route::post('places/{place}', [PlaceController::class, 'update_workaround']);
Route::post('files/{file}', [FileController::class, 'update_workaround']);