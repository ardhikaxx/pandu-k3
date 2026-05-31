<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\HazardReport;
use App\Models\CapaAction;
use App\Models\Inspection;
use App\Models\Certificate;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'open_hazards' => HazardReport::where('status', 'open')->count(),
            'pending_capa' => CapaAction::whereNotIn('status', ['closed'])->count(),
            'upcoming_inspections' => Inspection::where('status', 'scheduled')->count(),
            'expired_certificates' => Certificate::where('status', 'expired')->count(),
        ];

        return view('dashboard.hse', compact('stats'));
    }
}
