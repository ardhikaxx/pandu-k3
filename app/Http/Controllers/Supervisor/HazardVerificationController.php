<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\HazardReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HazardVerificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reports = HazardReport::where('division_id', $user->division_id)
            ->with(['reporter', 'workArea'])
            ->latest()
            ->paginate(10);

        return view('supervisor.hazard.index', compact('reports'));
    }

    public function show(HazardReport $hazardReport)
    {
        if ($hazardReport->division_id !== Auth::user()->division_id) {
            abort(403);
        }
        return view('supervisor.hazard.show', compact('hazardReport'));
    }

    public function verify(Request $request, HazardReport $hazardReport)
    {
        if ($hazardReport->division_id !== Auth::user()->division_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:in_review,in_progress,resolved,closed',
            'supervisor_notes' => 'required|string|min:10',
        ]);

        $hazardReport->update([
            'status' => $request->status,
            'supervisor_notes' => $request->supervisor_notes,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        if ($request->status === 'resolved') {
            $hazardReport->update(['resolved_at' => now()]);
        }

        // Log Activity
        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'verify',
            'module' => 'hazard_report',
            'record_id' => $hazardReport->id,
            'description' => "Verified hazard report {$hazardReport->report_number} as {$request->status}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('supervisor.hazard.index')
            ->with('success', "Laporan {$hazardReport->report_number} berhasil diperbarui.");
    }
}
