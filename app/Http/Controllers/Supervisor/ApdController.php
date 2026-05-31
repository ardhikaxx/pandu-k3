<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ApdInventory;
use App\Models\WorkArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApdController extends Controller
{
    public function index()
    {
        $items = ApdInventory::where('division_id', Auth::user()->division_id)
            ->with('workArea')
            ->latest()
            ->paginate(15);

        return view('supervisor.apd.index', compact('items'));
    }

    public function create()
    {
        $workAreas = WorkArea::where('division_id', Auth::user()->division_id)->get();
        return view('supervisor.apd.create', compact('workAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code' => 'required|string|unique:apd_inventories',
            'name' => 'required|string',
            'category' => 'required|in:helmet,vest,gloves,boots,goggles,mask,harness,earmuff,coverall,other',
            'total_quantity' => 'required|integer|min:0',
            'available_quantity' => 'required|integer|min:0|max:'.$request->total_quantity,
            'work_area_id' => 'required|exists:work_areas,id',
            'condition' => 'required|in:good,fair,poor,damaged',
        ]);

        ApdInventory::create([
            'item_code' => $request->item_code,
            'name' => $request->name,
            'category' => $request->category,
            'brand' => $request->brand,
            'model' => $request->model,
            'size' => $request->size,
            'work_area_id' => $request->work_area_id,
            'division_id' => Auth::user()->division_id,
            'total_quantity' => $request->total_quantity,
            'available_quantity' => $request->available_quantity,
            'damaged_quantity' => $request->total_quantity - $request->available_quantity,
            'condition' => $request->condition,
            'notes' => $request->notes,
        ]);

        return redirect()->route('supervisor.apd.index')
            ->with('success', 'Data inventaris APD berhasil ditambahkan.');
    }
}
