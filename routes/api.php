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
    Route::post("/posts", [HeroApiController::class, "create"]);
});


Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/list', [HeroApiController::class, 'list']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);
Route::post('/heroes', [HeroApiController::class, 'create']);
Route::put('/heroes/{id}', [HeroApiController::class, 'update']);
Route::delete('/heroes/{id}', [HeroApiController::class, 'delete']);


Route::get('/users', [UserApiController::class, 'all']);
Route::get('/users/{id}', [UserApiController::class, 'find']);
Route::post('/users', [UserApiController::class, 'create']);
Route::patch('/users/{id}', [UserApiController::class, 'update']);
Route::delete('/users/{id}', [UserApiController::class, 'delete']);
Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, 'login']);
