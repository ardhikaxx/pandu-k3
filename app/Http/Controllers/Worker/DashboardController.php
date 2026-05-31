<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\HazardReport;
use App\Models\IncidentReport;
use App\Models\PermitToWork;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $recent_hazards = HazardReport::where('reporter_id', $user_id)->latest()->take(3)->get();
        $stats = [
            'total_my_reports' => HazardReport::where('reporter_id', $user_id)->count() + IncidentReport::where('reporter_id', $user_id)->count(),
            'active_permits' => PermitToWork::where('applicant_id', $user_id)->where('status', 'approved')->count(),
        ];

        return view('dashboard.worker', compact('recent_hazards', 'stats'));
    }
}
