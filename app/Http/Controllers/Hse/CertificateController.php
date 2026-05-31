<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user')
            ->latest()
            ->paginate(15);

        return view('hse.certificate.index', compact('certificates'));
    }

    public function create()
    {
        $users = User::all();
        return view('hse.certificate.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_type' => 'required|in:k3_umum,k3_ahli,operator_forklift,operator_crane,welder,first_aid,fire_fighting,scaffolding,confined_space,other',
            'certificate_number' => 'required|string|unique:certificates',
            'issuing_body' => 'required|string',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('certificates', 'public');
        }

        $status = 'active';
        $daysToExpiry = now()->diffInDays($request->expiry_date, false);
        if ($daysToExpiry < 0) {
            $status = 'expired';
        } elseif ($daysToExpiry <= 30) {
            $status = 'expiring_soon';
        }

        Certificate::create([
            'user_id' => $request->user_id,
            'certificate_type' => $request->certificate_type,
            'certificate_number' => $request->certificate_number,
            'issuing_body' => $request->issuing_body,
            'issued_date' => $request->issued_date,
            'expiry_date' => $request->expiry_date,
            'status' => $status,
            'document_path' => $path,
        ]);

        return redirect()->route('hse.certificate.index')
            ->with('success', 'Sertifikat berhasil ditambahkan ke database.');
    }
}
