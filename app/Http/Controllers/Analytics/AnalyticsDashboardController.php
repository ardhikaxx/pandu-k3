<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Models\IncidentReport;
use App\Models\HazardReport;
use App\Models\CapaAction;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_incidents' => IncidentReport::count(),
            'open_hazards' => HazardReport::where('status', 'open')->count(),
            'closed_capa' => CapaAction::where('status', 'closed')->count(),
            'total_capa' => CapaAction::count(),
            'completed_inspections' => Inspection::where('status', 'completed')->count(),
        ];

        // Group hazards by category for doughnut chart
        $hazardCategories = HazardReport::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        return view('analytics.index', compact('stats', 'hazardCategories'));
    }
}
