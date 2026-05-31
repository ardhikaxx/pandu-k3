<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\WorkArea;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['division', 'company'])->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::all();
        $companies = Company::all();
        $workAreas = WorkArea::all();
        return view('admin.users.create', compact('divisions', 'companies', 'workAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:super_admin,hse_manager,supervisor,worker',
            'company_id' => 'required|exists:companies,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'employee_id' => $request->employee_id,
            'company_id' => $request->company_id,
            'division_id' => $request->division_id,
            'work_area_id' => $request->work_area_id,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }
}
