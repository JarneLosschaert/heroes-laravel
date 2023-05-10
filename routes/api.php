<?php

use App\Http\Controllers\HeroApiController;
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

Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);

Route::post('/heroes', [HeroApiController::class, 'create']);

Route::get('/users', [UserApiController::class, 'all']);
Route::get('/users/{id}', [UserApiController::class, 'find']);

Route::post('/users', [UserApiController::class, 'create']);
Route::put('/users/{id}', [UserApiController::class, 'update']);
