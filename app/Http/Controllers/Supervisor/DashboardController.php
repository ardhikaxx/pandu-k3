<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\HazardReport;
use App\Models\CapaAction;
use App\Models\Inspection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $division_id = Auth::user()->division_id;
        $stats = [
            'my_verifications' => HazardReport::where('division_id', $division_id)->where('status', 'open')->count(),
            'my_capa' => CapaAction::where('assigned_to', Auth::id())->whereNotIn('status', ['closed'])->count(),
            'my_inspections' => Inspection::where('inspector_id', Auth::id())->where('status', 'scheduled')->count(),
        ];

        return view('dashboard.supervisor', compact('stats'));
    }
}
