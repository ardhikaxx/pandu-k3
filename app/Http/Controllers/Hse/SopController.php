<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Sop;
use App\Models\WorkArea;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SopController extends Controller
{
    public function index()
    {
        $sops = Sop::with(['workArea', 'division', 'createdBy'])
            ->latest()
            ->paginate(15);

        return view('hse.sop.index', compact('sops'));
    }

    public function create()
    {
        $workAreas = WorkArea::all();
        $divisions = Division::all();
        return view('hse.sop.create', compact('workAreas', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|in:work_procedure,emergency_response,chemical_handling,equipment_operation,housekeeping,fire_safety,first_aid,evacuation,other',
            'content' => 'required|string',
            'document' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('sops', 'public');
        }

        $sop = Sop::create([
            'document_number' => generateDocumentNumber('SOP', Sop::class, 'document_number'),
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'work_area_id' => $request->work_area_id,
            'division_id' => $request->division_id,
            'created_by' => Auth::id(),
            'document_path' => $path,
            'status' => 'draft',
            'effective_date' => now(),
            'review_date' => now()->addYear(),
        ]);

        return redirect()->route('hse.sop.index')
            ->with('success', "SOP {$sop->document_number} berhasil dibuat sebagai draft.");
    }

    public function show(Sop $sop)
    {
        $sop->increment('view_count');
        return view('hse.sop.show', compact('sop'));
    }

    public function approve(Sop $sop)
    {
        $sop->update([
            'status' => 'active',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', "SOP {$sop->document_number} telah disetujui dan aktif.");
    }
}
