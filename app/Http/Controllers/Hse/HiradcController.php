<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Hiradc;
use App\Models\HiradcItem;
use App\Models\WorkArea;
use App\Models\Division;
use App\Http\Requests\HiradcRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HiradcController extends Controller
{
    public function index()
    {
        $documents = Hiradc::with(['workArea', 'division', 'preparedBy'])
            ->latest()
            ->paginate(15);

        return view('hse.hiradc.index', compact('documents'));
    }

    public function create()
    {
        $workAreas = WorkArea::all();
        $divisions = Division::all();
        return view('hse.hiradc.create', compact('workAreas', 'divisions'));
    }

    public function store(HiradcRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $hiradc = Hiradc::create([
                'document_number' => generateDocumentNumber('HRD', Hiradc::class, 'document_number'),
                'title' => $request->title,
                'work_area_id' => $request->work_area_id,
                'division_id' => $request->division_id,
                'prepared_by' => Auth::id(),
                'status' => 'draft',
                'valid_from' => $request->valid_from,
                'valid_until' => $request->valid_until,
            ]);

            foreach ($request->items as $item) {
                $scoreBefore = $item['severity_before'] * $item['probability_before'];
                $scoreAfter = $item['severity_after'] * $item['probability_after'];

                HiradcItem::create([
                    'hiradc_id' => $hiradc->id,
                    'activity' => $item['activity'],
                    'hazard_description' => $item['hazard_description'],
                    'hazard_type' => $item['hazard_type'],
                    'potential_incident' => $item['potential_incident'],
                    'severity_before' => $item['severity_before'],
                    'probability_before' => $item['probability_before'],
                    'risk_score_before' => $scoreBefore,
                    'risk_level_before' => calculateRiskLevel($scoreBefore),
                    'control_hierarchy' => $item['control_hierarchy'],
                    'control_measures' => $item['control_measures'],
                    'pic_control' => $item['pic_control'],
                    'target_date' => $item['target_date'],
                    'severity_after' => $item['severity_after'],
                    'probability_after' => $item['probability_after'],
                    'risk_score_after' => $scoreAfter,
                    'risk_level_after' => calculateRiskLevel($scoreAfter),
                    'residual_risk_acceptable' => $scoreAfter <= 4,
                ]);
            }

            return redirect()->route('hse.hiradc.index')
                ->with('success', "Dokumen HIRADC {$hiradc->document_number} berhasil dibuat sebagai draft.");
        });
    }

    public function show(Hiradc $hiradc)
    {
        $hiradc->load(['items', 'workArea', 'division', 'preparedBy', 'approvedBy']);
        return view('hse.hiradc.show', compact('hiradc'));
    }

    public function approve(Hiradc $hiradc)
    {
        $hiradc->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Dokumen {$hiradc->document_number} telah disetujui.");
    }
}
