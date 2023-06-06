<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TokenController;
use App\Models\Report;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
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

    // report
    Route::get('/anime-report', function () {
        $data = Report::all();
        return Inertia::render('Reports', [
            'data' => $data
        ]);
    })->name('reports');
    Route::delete('/anime-report/delete/{id}', function($id){
        $report = Report::find($id);
        $report->delete();
        return redirect()->route('reports')->with('message', 'Succesfully deleted');
    })->name('reportdelete');
    Route::get('/anime/report/reset', [GenerateController::class, 'resetreport'])->name('resetreport');
    
    // generate
    Route::post('/anime/generate', [GenerateController::class, 'genres'])->name('generateme');
    Route::get('/anime/generate/reset', [GenerateController::class, 'resetgenres'])->name('resetgenres');
});
