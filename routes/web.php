<?php

use App\Http\Controllers\HeroApiController;
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

Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);

Route::post('/heroes', [HeroApiController::class, 'create']);
Route::put('/heroes/{id}', [HeroApiController::class, 'update']);
Route::delete('/heroes/{id}', [HeroApiController::class, 'delete']);

Route::get('/users', [UserApiController::class, 'all']);
Route::get('/users/{id}', [UserApiController::class, 'find']);

Route::post('/users', [UserApiController::class, 'create']);
Route::put('/users/{id}', [UserApiController::class, 'update']);

