<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('/dashboard/series', DashboardController::class)->names('series');
    Route::resource('/dashboard/episodes', EpisodesController::class)->names('episodes');
    Route::resource('/dashboard/genres', GenresController::class)->names('genres');
    Route::get('/api-token', [TokenController::class, 'index'])->name('token');
});
