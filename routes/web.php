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

Route::get('/heroes', [HeroApiController::class, 'all']);
Route::get('/heroes/list', [HeroApiController::class, 'list']);
Route::get('/heroes/{id}', [HeroApiController::class, 'find']);
