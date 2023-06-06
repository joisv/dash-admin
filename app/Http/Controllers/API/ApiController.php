<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Episodes;
use App\Models\Genres;
use App\Models\Report;
use App\Models\Series;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getTopAnime() {
        try {

            $series = Series::orderBy('views', 'desc')
                        ->paginate(8)->withQueryString();

            return response()->json(['data' => $series], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function getAnime() {
        try {

            $series = Series::orderBy('created_at', 'desc')
                        ->paginate(9)->withQueryString();

            return response()->json(['data' => $series], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function getAnimeEpisodes() {
        try {

            $series = Episodes::orderBy('created_at', 'desc')->with('series')
                        ->paginate(9)->withQueryString();

            return response()->json(['data' => $series], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function getAnimeById(Series $series) {
        try {
            $series->increment('views');
            $data = $series->load( 'genres', 'episodes', 'resolutions');
            return response()->json(['data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'not found'], 404);
        }
    }
    public function getAnimeEpisodeById(Episodes $episodes) {
        try {
            $episodes->increment('views');
            $data = $episodes->load('resolutions');
            return response()->json(['data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'not found'], 404);
        }
    }
    public function getAnimeGenres() {
        try {

            $genres = Genres::orderBy('created_at', 'desc')
                        ->with('series')
                        ->paginate(5)->withQueryString();

            return response()->json(['data' => $genres], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function getAnimeSearch(Request $request) {
        try {

            $query = Series::query(); // Menginisialisasi query builder untuk model Series

            $filters = $request->only(['score', 'genres', 'status', 'type']);

            foreach ($filters as $key => $value) {
                if ($request->filled($key)) {
                    if ($key === 'genres') {
                        $query->whereHas('genres', function ($q) use ($value) {
                            $q->where('names', $value);
                        });
                    } else {
                        $query->where($key, $value);
                    }
                }
            }

            $data = $query->get();

            return response()->json(['data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getSeason($year, $season){
        try {

            $data = Series::where('year', $year)
            ->where('season', $season)
            ->get();

            return response()->json(['data' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function postReport( Request $request ) {

        try {
    
            $report = new Report();
            $report->title = $request['title'];
            $report->content = $request['content'];
            $report->save();
    
            return response()->json(['message' => 'report created succesfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'something went wrong'], 500);
        }
    }

}
