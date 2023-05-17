<?php

use App\Http\Controllers\HeroApiController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->group(function() {
    Route::post("/heroes", [HeroApiController::class, "create"]);
    Route::get('/heroes/favorites', [HeroApiController::class, 'favorites']);
    Route::patch('/user', [UserApiController::class, 'update']);
});

Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/list', [HeroApiController::class, 'list']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);
Route::put('/heroes/{id}', [HeroApiController::class, 'update']);
Route::delete('/heroes/{id}', [HeroApiController::class, 'delete']);

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, 'login']);
