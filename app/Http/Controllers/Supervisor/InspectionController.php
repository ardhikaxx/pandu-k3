<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\InspectionChecklistItem;
use App\Models\CapaAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    public function index()
    {
        $inspections = Inspection::where('inspector_id', Auth::id())
            ->with(['workArea', 'division'])
            ->latest()
            ->paginate(10);

        return view('supervisor.inspection.index', compact('inspections'));
    }

    public function show(Inspection $inspection)
    {
        if ($inspection->inspector_id !== Auth::id()) {
            abort(403);
        }
        $inspection->load('checklistItems');
        return view('supervisor.inspection.show', compact('inspection'));
    }

    public function complete(Request $request, Inspection $inspection)
    {
        if ($inspection->inspector_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.status' => 'required|in:ok,not_ok,na',
            'items.*.notes' => 'nullable|string',
            'items.*.photo' => 'nullable|image|max:2048',
        ]);

        return DB::transaction(function () use ($request, $inspection) {
            $totalItems = count($request->items);
            $checkedItems = 0;

            foreach ($request->items as $id => $data) {
                $item = InspectionChecklistItem::findOrFail($id);
                
                $photoPath = $item->photo;
                if (isset($data['photo'])) {
                    $photoPath = $data['photo']->store('inspections', 'public');
                }

                $item->update([
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'photo' => $photoPath,
                    'checked_by' => Auth::id(),
                    'checked_at' => now(),
                ]);

                // Auto CAPA logic
                if ($data['status'] === 'not_ok' && !$item->requires_capa) {
                    $item->update(['requires_capa' => true]);
                    
                    $capa = \App\Models\CapaAction::create([
                        'capa_number' => generateDocumentNumber('CPA', \App\Models\CapaAction::class, 'capa_number'),
                        'source_type' => 'inspection',
                        'source_id' => $inspection->id,
                        'title' => "Temuan Inspeksi: {$item->item_description}",
                        'description' => "Item '{$item->item_description}' dinyatakan NOT OK pada inspeksi {$inspection->inspection_number}. Catatan: {$data['notes']}",
                        'action_type' => 'corrective',
                        'priority' => 'medium',
                        'assigned_to' => Auth::id(),
                        'assigned_by' => $inspection->inspector_id,
                        'division_id' => $inspection->division_id,
                        'due_date' => now()->addDays(7),
                        'status' => 'open',
                    ]);
                    $item->update(['capa_id' => $capa->id]);
                }

                if ($data['status'] !== 'not_checked') $checkedItems++;
            }

            $inspection->update([
                'status' => 'completed',
                'completion_percentage' => ($checkedItems / $totalItems) * 100,
                'actual_date' => now(),
                'completed_at' => now(),
            ]);

            // Notify HSE Manager
            $hse = \App\Models\User::where('role', 'hse_manager')->first();
            if ($hse) {
                $hse->notify(new \App\Notifications\GeneralNotification(
                    "Inspeksi Selesai: {$inspection->inspection_number}",
                    "Inspeksi di {$inspection->workArea->name} telah diselesaikan oleh {$inspection->inspector->name}.",
                    route('hse.inspection.index')
                ));
            }

            return redirect()->route('supervisor.inspection.index')
                ->with('success', "Inspeksi {$inspection->inspection_number} telah diselesaikan.");
        });
    }
}
