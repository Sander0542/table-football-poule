<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlayersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');

Route::jetstreamMiddleware()->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'index']);

    Route::get('/games/random', [GamesController::class, 'random'])->name('games.random');
    Route::resource('/games', GamesController::class);

    Route::resource('/players', PlayersController::class)->parameters([
        'players' => 'user',
    ])->only(['index', 'show']);
});
