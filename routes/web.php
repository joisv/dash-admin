<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
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
    Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/series', DashboardController::class)->names('series');
    Route::resource('/dashboard/episodes', EpisodesController::class)->names('episodes');
    Route::resource('/dashboard/genres', GenresController::class)->names('genres');
    Route::get('/api-token', [TokenController::class, 'index'])->name('token');
    Route::post('/api-token/create', [TokenController::class, 'gettoken'])->name('gettoken');
    Route::post('/anime/full', function ($id) {
        $response = Http::get("https://api.jikan.moe/v4/anime/".$id."/full");
        return response()->json($response);
    });
    Route::post('/anime/generate', [SearchController::class, 'index'])->name('gen');
});
