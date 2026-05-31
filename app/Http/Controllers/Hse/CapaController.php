<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\CapaAction;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CapaController extends Controller
{
    public function index()
    {
        $actions = CapaAction::with(['assignedTo', 'division', 'assignedBy'])
            ->latest()
            ->paginate(15);

        return view('hse.capa.index', compact('actions'));
    }

    public function create()
    {
        $users = User::all();
        $divisions = Division::all();
        return view('hse.capa.create', compact('users', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'action_type' => 'required|in:corrective,preventive,improvement',
            'priority' => 'required|in:low,medium,high,critical',
            'assigned_to' => 'required|exists:users,id',
            'division_id' => 'required|exists:divisions,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $capa = CapaAction::create([
            'capa_number' => generateDocumentNumber('CPA', CapaAction::class, 'capa_number'),
            'title' => $request->title,
            'description' => $request->description,
            'action_type' => $request->action_type,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => Auth::id(),
            'division_id' => $request->division_id,
            'due_date' => $request->due_date,
            'status' => 'open',
            'source_type' => $request->source_type ?? 'hazard_report', // Default
            'source_id' => $request->source_id ?? 0,
        ]);

        return redirect()->route('hse.capa.index')
            ->with('success', "CAPA {$capa->capa_number} berhasil dibuat dan ditugaskan.");
    }

    public function show(CapaAction $capaAction)
    {
        $capaAction->load(['assignedTo', 'division', 'assignedBy', 'verifiedBy']);
        return view('hse.capa.show', compact('capaAction'));
    }

    public function verify(Request $request, CapaAction $capaAction)
    {
        $request->validate([
            'effectiveness_rating' => 'required|integer|between:1,5',
            'status' => 'required|in:closed,open',
        ]);

        $capaAction->update([
            'status' => $request->status,
            'effectiveness_rating' => $request->effectiveness_rating,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('hse.capa.index')
            ->with('success', "CAPA {$capaAction->capa_number} telah diverifikasi dan status diubah menjadi {$request->status}.");
    }
}
