<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\HazardReport;
use App\Models\WorkArea;
use App\Http\Requests\HazardReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HazardReportController extends Controller
{
    public function index()
    {
        $reports = HazardReport::where('reporter_id', Auth::id())
            ->with(['workArea', 'division'])
            ->latest()
            ->paginate(10);

        return view('worker.hazard.index', compact('reports'));
    }

    public function create()
    {
        $workAreas = WorkArea::where('company_id', Auth::user()->company_id)->get();
        return view('worker.hazard.create', compact('workAreas'));
    }

    public function store(HazardReportRequest $request)
    {
        $user = Auth::user();
        $photos = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('hazards', 'public');
                $photos[] = $path;
            }
        }

        $report = HazardReport::create([
            'report_number' => generateDocumentNumber('HAZ', HazardReport::class),
            'reporter_id' => $user->id,
            'work_area_id' => $request->work_area_id,
            'division_id' => $user->division_id,
            'hazard_type' => $request->hazard_type,
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
            'location_detail' => $request->location_detail,
            'severity' => $request->severity,
            'priority' => determinePriority($request->severity),
            'photos' => $photos,
            'status' => 'open',
            'reported_at' => now(),
        ]);

        // Auto CAPA logic for High/Critical
        if (in_array($report->severity, ['high', 'critical'])) {
            $capa = \App\Models\CapaAction::create([
                'capa_number' => generateDocumentNumber('CPA', \App\Models\CapaAction::class, 'capa_number'),
                'source_type' => 'hazard_report',
                'source_id' => $report->id,
                'title' => "Tindakan Segera: {$report->title}",
                'description' => "Otomatis dibuat dari laporan bahaya {$report->report_number}. Deskripsi: {$report->description}",
                'action_type' => 'corrective',
                'priority' => $report->severity === 'critical' ? 'critical' : 'high',
                'assigned_to' => \App\Models\User::where('role', 'supervisor')->where('division_id', $report->division_id)->first()->id ?? $user->id,
                'assigned_by' => $user->id,
                'division_id' => $report->division_id,
                'due_date' => now()->addDays(2),
                'status' => 'open',
            ]);
            $report->update(['capa_id' => $capa->id]);
        }

        // Notify Supervisor
        $supervisor = \App\Models\User::where('role', 'supervisor')->where('division_id', $user->division_id)->first();
        if ($supervisor) {
            $supervisor->notify(new \App\Notifications\GeneralNotification(
                "Laporan Bahaya Baru: {$report->report_number}",
                "Temuan bahaya baru di {$report->workArea->name} perlu verifikasi Anda.",
                route('supervisor.hazard.show', $report->id)
            ));
        }

        // Log Activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'create',
            'module' => 'hazard_report',
            'record_id' => $report->id,
            'description' => "Submitted hazard report {$report->report_number}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('worker.hazard.index')
            ->with('success', "Laporan Bahaya {$report->report_number} berhasil dikirim.");
    }

    public function show(HazardReport $hazardReport)
    {
        if ($hazardReport->reporter_id !== Auth::id()) {
            abort(403);
        }
        return view('worker.hazard.show', compact('hazardReport'));
    }
}
