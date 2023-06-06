<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Report;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    public function genres(Request $request){
        foreach ($request->name as $data) {
            # code...
            $genres = new Genres();
            $genres->names = $data;
            $genres->setSlugAttribute($data);
            $genres->save();
        }

        return redirect()->route('genres.index')->with('message', 'Genre berhasil di generate');
    }

    public function resetgenres(){
        try {
            Genres::truncate();
            return redirect()->route('genres.index')->with('message', 'Genre berhasil di reset');
        } catch (\Exception $e) {
            return redirect()->route('genres.index')->with('message', 'Genre gagal di reset');
        }
    }
    public function resetreport(){
        try {
            Report::truncate();
            return redirect()->route('reports')->with('message', 'berhasil di reset');
        } catch (\Exception $e) {
            return redirect()->route('genres.index')->with('message', 'gagal di reset');
        }
    }
}
