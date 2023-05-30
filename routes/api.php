<?php

use App\Http\Controllers\API\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return response()->json($request->user());
// });
// MU1puT3vjOeRkDm5DW0tMtTEbqdCSO9jivN6iTvn
Route::prefix('v1')->middleware('auth:sanctum')->group(function (){
    Route::get('/popular', [ApiController::class, 'popular']);
    Route::get('/new', [ApiController::class, 'new']);
    Route::get('/show/{series:slug}', [ApiController::class, 'show']);
    Route::get('/showeps/{episodes:id}', [ApiController::class, 'showeps']);
    Route::get('/genres', [ApiController::class, 'genres']);
    Route::get('/genres/q/{genres:id}', [ApiController::class, 'genresQ']);

    // new

    Route::get('top/anime' , [ApiController::class , 'top']);
});
