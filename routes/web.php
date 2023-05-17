<?php

use App\Http\Controllers\HeroApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\RouteAction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:api')->group(function() {
    Route::post("/heroes", [HeroApiController::class, "create"]);
    Route::get('/favorites', [HeroApiController::class, 'favorites']);
    Route::patch('/user', [UserApiController::class, 'update']);
});

Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/list', [HeroApiController::class, 'list']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);
Route::put('/heroes/{id}', [HeroApiController::class, 'update']);
Route::delete('/heroes/{id}', [HeroApiController::class, 'delete']);

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, 'login']);

