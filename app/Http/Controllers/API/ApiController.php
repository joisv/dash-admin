<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Genres;
use App\Models\Series;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function popular() {
        try {

            $series = Series::orderBy('views', 'desc')
                        ->paginate(8)->withQueryString();

            return response()->json(['data' => $series], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function new() {
        try {

            $series = Series::orderBy('created_at', 'desc')
                        ->paginate(9)->withQueryString();

            return response()->json(['data' => $series], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function show(Series $series) {
        try {
            $series->increment('views');
            $data = $series->load( 'genres', 'episodes', 'resolutions');
            return response()->json(['data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'not found'], 404);
        }
    }
    public function genres() {
        try {

            $genres = Genres::orderBy('created_at', 'desc')
                        ->with('series')
                        ->paginate(5)->withQueryString();

            return response()->json(['data' => $genres], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function genresQ(Genres $genres) {
        try {

            $genres = $genres->load('series');
            return response()->json(['data' => $genres], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

}
