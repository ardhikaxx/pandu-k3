<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\CapaAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapaExecutionController extends Controller
{
    public function index()
    {
        $actions = CapaAction::where('assigned_to', Auth::id())
            ->with(['assignedBy', 'division'])
            ->latest()
            ->paginate(10);

        return view('supervisor.capa.index', compact('actions'));
    }

    public function show(CapaAction $capaAction)
    {
        if ($capaAction->assigned_to !== Auth::id()) {
            abort(403);
        }
        return view('supervisor.capa.show', compact('capaAction'));
    }

    public function update(Request $request, CapaAction $capaAction)
    {
        if ($capaAction->assigned_to !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:in_progress,pending_verification',
            'progress_notes' => 'required|string|min:10',
            'evidence' => 'nullable|array|min:1',
            'evidence.*' => 'image|max:5120',
        ]);

        $evidence = $capaAction->completion_evidence ?? [];
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('capa_evidence', 'public');
                $evidence[] = $path;
            }
        }

        $capaAction->update([
            'status' => $request->status,
            'progress_notes' => $request->progress_notes,
            'completion_evidence' => $evidence,
        ]);

        if ($request->status === 'pending_verification') {
            $capaAction->update(['completed_at' => now()]);
        }

        return redirect()->route('supervisor.capa.index')
            ->with('success', "CAPA {$capaAction->capa_number} berhasil diperbarui.");
    }
}
