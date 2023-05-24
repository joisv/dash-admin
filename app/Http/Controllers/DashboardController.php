<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('DashboardSeries/Index', [
            'series' => Series::query()
                        ->when($request->input('search'),function($query, $search) {
                            $query->where('title','like','%'.$search.'%')
                            ->OrWhere('original_title','like','%'.$search.'%');
                        })->orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genres::all();
        return Inertia::render('DashboardSeries/Create', [
            'genres' => $genres
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:100|string',
            'original_title' => 'max:100|string|nullable',
            'type' => 'required|string',
            'image' => $request->hasFile('image') ? 'file|2048' : 'required|url',
            'genres' => 'required',
            'score' => 'required',
            'status' => 'required|string',
            'season' => 'string',
            'year' => 'integer',
            'synopsis' => 'string|max:2024|nullable',
            'resolutions' => 'array',
        ]);
        
        
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
        
        if(isset($data['resolutions'])){
            foreach ($data['resolutions'] as $resolution ) {
                $resolutionData = [
                    'resolution' => $resolution['resolution'],
                    'url' => $resolution['url'],
                    'download_url' => $resolution['download_url']
                ];
            
                $series->resolutions()->create($resolutionData);
            }
        }

        return redirect()->route('series.index')->with('message', 'Post berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $series = Series::findOrFail($id);
        return Inertia::render('DashboardSeries/Edit', [
            'series' => $series->with(['genres', 'resolutions'])->find($series->id),
            'genres' => Genres::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $series = Series::find($id);
       $series->title = $request['title'];
       $series->original_title = $request['original_title'];
       $series->setSlugAttribute($request['title']);
       $series->type = $request['type'];
       $series->score = $request['score'];
       $series->status = $request['status'];
       $series->season = $request['season'];
       $series->year = $request['year'];
       $series->save();
       $series->genres()->sync($request['genres']);

       if ($request->hasFile('image')) {
           if($request->oldImg){
               Storage::delete($request->oldImage);
           }
           $image = $request->file('image');
           $imagePath = $image->store('public/series-images');
           $series->image = basename($imagePath);
       }
       $series->resolutions()->delete();
   
       // Tambahkan resolusi baru
       foreach ($request['resolutions'] as $resolution ) {
           $resolutionData = [
               'resolution' => $resolution['resolution'],
               'url' => $resolution['url'],
               'download_url' => $resolution['download_url']
           ];
   
           $series->resolutions()->create($resolutionData);
       }
   
       return redirect()->route('series.index')->with('message', 'Post berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Series $series)
    {
        if ($series->image)
        {
         Storage::delete($series->image);
        }
        Series::destroy($series->id);
        sleep(2);
        return redirect()->route('series.index')->with('message', 'Post Delete Successfully');
    }

}
