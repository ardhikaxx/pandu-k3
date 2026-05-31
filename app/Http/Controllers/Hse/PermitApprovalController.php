<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\PermitToWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitApprovalController extends Controller
{
    public function index()
    {
        $permits = PermitToWork::with(['applicant', 'workArea', 'supervisor'])
            ->latest()
            ->paginate(15);

        return view('hse.permit.index', compact('permits'));
    }

    public function show(PermitToWork $permitToWork)
    {
        return view('hse.permit.show', compact('permitToWork'));
    }

    public function approve(Request $request, PermitToWork $permitToWork)
    {
        $request->validate([
            'status' => 'required|in:approved,cancelled',
        ]);

        $permitToWork->update([
            'status' => $request->status,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $msg = $request->status === 'approved' ? 'disetujui' : 'ditolak';
        return redirect()->route('hse.permit.index')
            ->with('success', "Izin Kerja {$permitToWork->permit_number} telah {$msg}.");
    }
}
