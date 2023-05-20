<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $sixDaysAgo = Carbon::today()->subDays(6);

        $dates = [];
        $viewsData = [];

        // Loop melalui setiap hari dalam rentang tanggal
        for ($date = $sixDaysAgo; $date <= $today; $date->addDay()) {
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();

            // Mengambil jumlah views pada rentang 24 jam di hari tersebut
            $views = Series::whereBetween('created_at', [$startOfDay, $endOfDay])
                ->sum('views');

            $dates[] = $date->format('l'); // Menyimpan hari dalam format 'hari'
            $viewsData[] = $views; // Menyimpan jumlah views
        }

        $new = Series::orderBy('created_at', 'desc')->take(5)->get();
        $statusCount = Series::whereIn('status', ['complete', 'ongoing', 'pending'])
                ->select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')
                ->get();

        return Inertia::render('Dashboard', [
            'dates' => $dates,
            'views' => $viewsData,
            'new' => $new,
            'status' => $statusCount
        ]);
    }
}
