<?php

use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    Route::get('/anime/full/{id}', function ($id) {
        try {
            $url = "https://api.jikan.moe/v4/anime/" . $id;
        
            // Inisialisasi sesi cURL
            $ch = curl_init();
            
            // Set URL yang akan dituju
            curl_setopt($ch, CURLOPT_URL, $url);
            
            // Aktifkan opsi untuk mengembalikan respons sebagai string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Eksekusi permintaan cURL
            $response = curl_exec($ch);
            $response = json_decode($response, true); 
            
            // Periksa apakah permintaan berhasil
            if ($response === false) {
                $error = curl_error($ch);
                // Handle error jika terjadi
                return response()->json(['error' => $error]);
            } else {
                // Handle respons yang berhasil
                return response()->json(['data' => $response]);
            }
            
            // Tutup sesi cURL
            curl_close($ch);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'something fucked up']);
        }
    });

    Route::get('/top/anime', [ApiController::class, 'popular']);
    Route::get('/new', [ApiController::class, 'new']);
    Route::get('/anime/{series:slug}/full', [ApiController::class, 'show']);
    Route::get('/anime/{episodes:id}/episode', [ApiController::class, 'showeps']);
    Route::get('/genres/anime', [ApiController::class, 'genres']);
    Route::get('/genres/q/{genres:id}', [ApiController::class, 'genresQ']);
});
