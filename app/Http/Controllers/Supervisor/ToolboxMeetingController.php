<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ToolboxMeeting;
use App\Models\WorkArea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolboxMeetingController extends Controller
{
    public function index()
    {
        $meetings = ToolboxMeeting::where('division_id', Auth::user()->division_id)
            ->with(['workArea', 'facilitator'])
            ->latest()
            ->paginate(15);

        return view('supervisor.toolbox.index', compact('meetings'));
    }

    public function create()
    {
        $workAreas = WorkArea::where('division_id', Auth::user()->division_id)->get();
        return view('supervisor.toolbox.create', compact('workAreas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'topic' => 'required|string',
            'work_area_id' => 'required|exists:work_areas,id',
            'meeting_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'location' => 'required|string',
            'agenda' => 'required|string',
        ]);

        $meeting = ToolboxMeeting::create([
            'meeting_number' => generateDocumentNumber('TBM', ToolboxMeeting::class, 'meeting_number'),
            'title' => $request->title,
            'topic' => $request->topic,
            'work_area_id' => $request->work_area_id,
            'division_id' => Auth::user()->division_id,
            'facilitator_id' => Auth::id(),
            'meeting_date' => $request->meeting_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'agenda' => $request->agenda,
            'status' => 'scheduled',
        ]);

        return redirect()->route('supervisor.toolbox.index')
            ->with('success', "Toolbox Meeting {$meeting->meeting_number} berhasil dijadwalkan.");
    }

    public function show(ToolboxMeeting $toolboxMeeting)
    {
        $toolboxMeeting->load(['workArea', 'attendances.user']);
        return view('supervisor.toolbox.show', compact('toolboxMeeting'));
    }
}
