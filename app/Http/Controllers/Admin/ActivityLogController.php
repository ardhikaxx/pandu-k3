<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->has('module') && $request->module != '') {
            $query->where('module', $request->module);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(30);

        return view('admin.activity.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('admin.activity.show', compact('activityLog'));
    }
}
