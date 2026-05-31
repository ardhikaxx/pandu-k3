<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentInvestigationController extends Controller
{
    public function index()
    {
        $reports = IncidentReport::with(['reporter', 'workArea'])
            ->latest()
            ->paginate(15);

        return view('hse.incident.index', compact('reports'));
    }

    public function show(IncidentReport $incidentReport)
    {
        return view('hse.incident.show', compact('incidentReport'));
    }

    public function investigate(Request $request, IncidentReport $incidentReport)
    {
        $request->validate([
            'immediate_cause' => 'required|string',
            'root_cause' => 'required|string',
            'investigation_report' => 'required|string',
            'severity_classification' => 'required|in:minor,moderate,serious,major,catastrophic',
            'status' => 'required|in:action_required,closed',
        ]);

        $incidentReport->update([
            'immediate_cause' => $request->immediate_cause,
            'root_cause' => $request->root_cause,
            'investigation_report' => $request->investigation_report,
            'severity_classification' => $request->severity_classification,
            'status' => $request->status,
            'investigated_by' => Auth::id(),
        ]);

        if ($request->status === 'closed') {
            $incidentReport->update(['closed_at' => now()]);
        }

        return redirect()->route('hse.incident.index')
            ->with('success', "Investigasi insiden {$incidentReport->report_number} telah diperbarui.");
    }
}
