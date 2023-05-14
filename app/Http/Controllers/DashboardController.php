<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $series = Series::all();
        return Inertia::render('DashboardSeries/Index', [
            'series' => $series
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DashboardSeries/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $data = $request->validate([
            'title' => 'required|max:100|string',
            'type' => 'required|string',
            'image' => '|file|max:2048',
            'score' => 'required|string',
            'status' => 'required|string',
            'synopsis' => 'string|max:255',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/series-images');
            $data['image'] = basename($imagePath);
        }
        $series = new Series();
        $series->title = $data['title'];
        $series->setSlugAttribute($data['title']);
        $series->type = $data['type'];
        $series->image = $data['image'];
        $series->score = $data['score'];
        $series->status = $data['status'];
        $series->synopsis = $data['synopsis'];
        $series->save();

        return redirect()->route('series.index')->with('success', 'Post berhasil disimpan');
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
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request, $query){
        return response()->json(['query' => $query]);
    } 
}
