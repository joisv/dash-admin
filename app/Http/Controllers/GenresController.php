<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('DashboardGenres/Index', [
            'genres' => Genres::query()
                        ->when($request->input('search'),function($query, $search) {
                            $query->where('names','like','%'.$search.'%');
                        })->orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('DashboardGenres/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'names' => 'required|max:100'
        ]);
         $genres = new Genres();
         $genres->names = $data['names'];
         $genres->setSlugAttribute($data['names']);
         $genres->save();

         return redirect()->route('genres.index')->with('message', 'Genre berhasil ditambahkan');

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
        $genre = Genres::findOrFail($id);
        return Inertia::render('DashboardGenres/Edit', [
            'genre' => $genre
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request);
       $data = $request->validate([
            'names' => 'max:100|required'
       ]);

       $genre = Genres::findOrFail($id);
       $genre->names = $data['names'];
       $genre->setSlugAttribute($data['names']);
       $genre->save();

       return redirect()->route('genres.index')->with('message', 'Episode berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genres::findOrFail($id);
        $genre->delete();
    }
}
