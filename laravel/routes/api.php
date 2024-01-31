<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

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
Route::get('files',[ FileController::class, 'index']);
Route::get('files',[ FileController::class, 'show']);
Route::post('files',[ FileController::class, 'store']);
Route::put('files',[ FileController::class, 'update']);
Route::delete('files',[ FileController::class, 'destroy']);
Route::resource('/api/files', FileController::class);
