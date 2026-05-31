<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\User;
use App\Models\WorkArea;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionScheduleController extends Controller
{
    public function index()
    {
        $inspections = Inspection::with(['workArea', 'division', 'inspector'])
            ->latest()
            ->paginate(15);

        return view('hse.inspection.index', compact('inspections'));
    }

    public function create()
    {
        $workAreas = WorkArea::all();
        $divisions = Division::all();
        $inspectors = User::whereIn('role', ['supervisor', 'hse_manager'])->get();
        return view('hse.inspection.create', compact('workAreas', 'divisions', 'inspectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'inspection_type' => 'required|in:daily,weekly,monthly,special,audit_follow_up',
            'work_area_id' => 'required|exists:work_areas,id',
            'division_id' => 'required|exists:divisions,id',
            'inspector_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
        ]);

        $inspection = Inspection::create([
            'inspection_number' => generateDocumentNumber('INS', Inspection::class, 'inspection_number'),
            'title' => $request->title,
            'inspection_type' => $request->inspection_type,
            'work_area_id' => $request->work_area_id,
            'division_id' => $request->division_id,
            'inspector_id' => $request->inspector_id,
            'scheduled_date' => $request->scheduled_date,
            'status' => 'scheduled',
        ]);

        return redirect()->route('hse.inspection.index')
            ->with('success', "Inspeksi {$inspection->inspection_number} berhasil dijadwalkan.");
    }
}
