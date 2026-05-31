<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\WorkArea;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with(['workArea', 'division', 'leadAuditor'])
            ->latest()
            ->paginate(15);

        return view('hse.audit.index', compact('audits'));
    }

    public function create()
    {
        $workAreas = WorkArea::all();
        $divisions = Division::all();
        $auditors = User::whereIn('role', ['hse_manager', 'super_admin'])->get();
        return view('hse.audit.create', compact('workAreas', 'divisions', 'auditors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'audit_type' => 'required|in:internal,external,surveillance,certification',
            'work_area_id' => 'required|exists:work_areas,id',
            'division_id' => 'required|exists:divisions,id',
            'lead_auditor_id' => 'required|exists:users,id',
            'scheduled_start' => 'required|date',
            'scheduled_end' => 'required|date|after:scheduled_start',
            'scope' => 'required|string',
            'criteria' => 'required|string',
        ]);

        $audit = Audit::create([
            'audit_number' => generateDocumentNumber('AUD', Audit::class, 'audit_number'),
            'title' => $request->title,
            'audit_type' => $request->audit_type,
            'work_area_id' => $request->work_area_id,
            'division_id' => $request->division_id,
            'lead_auditor_id' => $request->lead_auditor_id,
            'team_members' => $request->team_members ?? [],
            'scheduled_start' => $request->scheduled_start,
            'scheduled_end' => $request->scheduled_end,
            'scope' => $request->scope,
            'criteria' => $request->criteria,
            'status' => 'planned',
        ]);

        return redirect()->route('hse.audit.index')
            ->with('success', "Audit {$audit->audit_number} telah direncanakan.");
    }

    public function show(Audit $audit)
    {
        return view('hse.audit.show', compact('audit'));
    }
}
