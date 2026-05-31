<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\PermitToWork;
use App\Models\WorkArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitController extends Controller
{
    public function index()
    {
        $permits = PermitToWork::where('applicant_id', Auth::id())
            ->with(['workArea', 'supervisor'])
            ->latest()
            ->paginate(10);

        return view('worker.permit.index', compact('permits'));
    }

    public function create()
    {
        $workAreas = WorkArea::all();
        $supervisors = User::where('role', 'supervisor')->get();
        return view('worker.permit.create', compact('workAreas', 'supervisors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'work_type' => 'required|in:hot_work,confined_space,working_at_height,electrical,excavation,chemical_handling,crane_lifting,other',
            'work_area_id' => 'required|exists:work_areas,id',
            'supervisor_id' => 'required|exists:users,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'required_ppe' => 'required|array',
            'precautions' => 'required|string',
        ]);

        $permit = PermitToWork::create([
            'permit_number' => generateDocumentNumber('PTW', PermitToWork::class, 'permit_number'),
            'title' => $request->title,
            'work_type' => $request->work_type,
            'work_area_id' => $request->work_area_id,
            'division_id' => Auth::user()->division_id,
            'applicant_id' => Auth::id(),
            'supervisor_id' => $request->supervisor_id,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'required_ppe' => $request->required_ppe,
            'precautions' => $request->precautions,
            'status' => 'submitted',
        ]);

        return redirect()->route('worker.permit.index')
            ->with('success', "Pengajuan Izin Kerja {$permit->permit_number} telah dikirim.");
    }
}
