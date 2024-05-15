<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/comment', [commentController::class , 'store']);
Route::get('document/{id}/comments', [DocumentController::class , 'getComment']);

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');

});

Route::post('/document', [DocumentController::class , 'store'])->middleware('auth:api');
Route::get('/document', [DocumentController::class , 'index']);
Route::get('/document', [DocumentController::class , 'show']);
Route::put('/document', [DocumentController::class , 'update']);
Route::delete('/document', [DocumentController::class , 'destroy']);
Route::post('upload', 'DocumentController@upload')->middleware('document.upload') ;