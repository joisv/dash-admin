<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
    
        $series = new Series();
        $series->title = $data['title'];
        $series->original_title = $data['original_title'];
        $series->setSlugAttribute($data['title']);
        $series->type = $data['type'];
        $series->score = $data['score'];
        $series->status = $data['status'];
        $series->season = $data['season'];
        $series->year = $data['year'];
        $series->synopsis = $data['synopsis'];
        $series->save();
        $series->genres()->sync($data['genres']);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/series-images');
            $series->image = basename($imagePath);
        }
    
        if (isset($data['resolutions'])) {
            foreach ($data['resolutions'] as $resolution) {
                $resolutionData = [
                    'resolution' => $resolution['resolution'],
                    'url' => $resolution['url']
                ];
    
                $series->resolutions()->create($resolutionData);
            }
        }
    
        return redirect()->route('series.index')->with('message', 'Post berhasil disimpan');
    }
    
}
