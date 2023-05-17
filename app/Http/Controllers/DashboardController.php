<?php

namespace App\Http\Controllers;

use App\Models\Episodes;
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
        // $series = Series::orderBy('created_at', 'desc')->get();
        // dd($series);
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
            'image' => '|file|max:2048',
            'genres' => 'required',
            'score' => 'required|string',
            'status' => 'nullable|string',
            'synopsis' => 'string|max:255|nullable',
            'resolutions' => 'array'
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/series-images');
            $data['image'] = basename($imagePath);
        }
        
        $series = new Series();
        $series->title = $data['title'];
        $series->original_title = $data['original_title'];
        $series->setSlugAttribute($data['title']);
        $series->type = $data['type'];
        $series->image = $data['image'];
        $series->score = $data['score'];
        $series->status = $data['status'];
        $series->synopsis = $data['synopsis'];
        $series->save();
        $series->genres()->sync($data['genres']);
        
        if(isset($data['resolutions'])){
            foreach ($data['resolutions'] as $resolution ) {
                $resolutionData = [
                    'resolution' => $resolution['resolution'],
                    'url' => $resolution['url']
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
    public function edit(Series $series)
    {
        return Inertia::render('DashboardSeries/Edit', [
            'series' => $series->with('genres')->find($series->id),
            'genres' => Genres::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
