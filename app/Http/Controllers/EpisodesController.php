<?php

namespace App\Http\Controllers;

use App\Models\Episodes;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EpisodesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('DashboardEpisodes/Index', [
            'episodes' => Episodes::query()
                        ->when($request->input('search'),function($query, $search) {
                            $query->where('title','like','%'.$search.'%');
                        })->orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DashboardEpisodes/Create', [
            'series' => Series::select('title', 'id')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
            'title' => 'string|max:100|required',
            'series_id' => 'required'
        ]);

       $episodes = new Episodes();
       $episodes->title = $data['title'];
       $episodes->setSlugAttribute($data['title']); 
       $episodes->series_id = $data['series_id'];
       $episodes->save(); 

       return redirect()->route('episodes.index')->with('message', 'Episode baru berhasil ditambahkan');
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
        $episodes = Episodes::find($id);
        return Inertia::render('DashboardEpisodes/Edit', [
            'episodes' => $episodes->with('series')->find($id),
            'series' => Series::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request);
        $data = $request->validate([
            'title' => 'string|max:100|required',
            'series_id' => 'required'
        ]);

        $episode = Episodes::find($request->id);
        $episode->title = $data['title'];
        $episode->setSlugAttribute($data['title']); 
        $episode->series_id = $data['series_id'];
        $episode->save(); 

        return redirect()->route('episodes.index')->with('message', 'Episode baru berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $episodes = Episodes::find($id);
        $episodes->delete();
        // sleep(2);
        return redirect()->route('episodes.index')->with('message', 'Post Deleted');
    }
}
