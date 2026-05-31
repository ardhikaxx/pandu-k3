<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\IncidentReport;
use App\Models\HazardReport;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_incidents' => IncidentReport::count(),
            'total_hazards' => HazardReport::count(),
            'total_companies' => Company::count(),
        ];

        return view('dashboard.admin', compact('stats'));
    }
}
