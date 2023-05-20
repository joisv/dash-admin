<?php

namespace App\Http\Controllers;

use App\Models\Episodes;
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
        for ($date = $sixDaysAgo; $date <= $today; $date->addDay()) {
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();
            $views = Series::whereBetween('created_at', [$startOfDay, $endOfDay])
                ->sum('views');
            $dates[] = $date->format('l');
            $viewsData[] = $views;
        }

        $totalViewsSeries = Series::sum('views');
        $totalViewsEpisodes = Episodes::sum('views');
        $new = Series::orderBy('created_at', 'desc')->take(5)->get();
        $statusCount = Series::whereIn('status', ['complete', 'ongoing', 'pending'])
                ->select('status', DB::raw('COUNT(*) as count'))
                ->groupBy('status')
                ->get();
        
        return Inertia::render('Dashboard', [
            'dates' => $dates,
            'views' => $viewsData,
            'new' => $new,
            'totalViews' => $totalViewsSeries,
            'totalViewsEps' => $totalViewsEpisodes,
            'status' => $statusCount
        ]);
    }
}
