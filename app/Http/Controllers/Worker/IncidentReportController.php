<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\IncidentReport;
use App\Models\WorkArea;
use App\Http\Requests\IncidentReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentReportController extends Controller
{
    public function index()
    {
        $reports = IncidentReport::where('reporter_id', Auth::id())
            ->with(['workArea'])
            ->latest()
            ->paginate(10);

        return view('worker.incident.index', compact('reports'));
    }

    public function create()
    {
        $workAreas = WorkArea::where('company_id', Auth::user()->company_id)->get();
        return view('worker.incident.create', compact('workAreas'));
    }

    public function store(IncidentReportRequest $request)
    {
        $user = Auth::user();
        $photos = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('incidents', 'public');
                $photos[] = $path;
            }
        }

        $report = IncidentReport::create([
            'report_number' => generateDocumentNumber('INC', IncidentReport::class),
            'reporter_id' => $user->id,
            'work_area_id' => $request->work_area_id,
            'division_id' => $user->division_id,
            'incident_type' => $request->incident_type,
            'incident_date' => $request->incident_date,
            'incident_time' => $request->incident_time,
            'title' => $request->title,
            'description' => $request->description,
            'victim_name' => $request->victim_name,
            'victim_employee_id' => $request->victim_employee_id,
            'photos' => $photos,
            'status' => 'submitted',
            'severity_classification' => $request->severity_classification,
            'submitted_at' => now(),
        ]);

        // Change status to under_investigation as per rules
        $report->update(['status' => 'under_investigation']);

        // Log Activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'create',
            'module' => 'incident_report',
            'record_id' => $report->id,
            'description' => "Submitted incident report {$report->report_number}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('worker.incident.index')
            ->with('success', "Laporan Insiden {$report->report_number} berhasil dikirim dan sedang dalam investigasi.");
    }

    public function show(IncidentReport $incidentReport)
    {
        if ($incidentReport->reporter_id !== Auth::id()) {
            abort(403);
        }
        return view('worker.incident.show', compact('incidentReport'));
    }
}
