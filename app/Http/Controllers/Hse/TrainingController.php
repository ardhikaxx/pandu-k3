<?php

namespace App\Http\Controllers\Hse;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Division;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::with('division')
            ->latest()
            ->paginate(15);

        return view('hse.training.index', compact('trainings'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('hse.training.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|in:induction,refresher,specialist,emergency_drill,regulatory,on_the_job',
            'provider' => 'required|string',
            'trainer_name' => 'required|string',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:scheduled_date',
            'location' => 'required|string',
            'max_participants' => 'required|integer|min:1',
            'duration_hours' => 'required|numeric|min:0.5',
            'description' => 'required|string',
        ]);

        $training = Training::create([
            'training_number' => generateDocumentNumber('TRN', Training::class, 'training_number'),
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'provider' => $request->provider,
            'trainer_name' => $request->trainer_name,
            'trainer_credential' => $request->trainer_credential,
            'division_id' => $request->division_id,
            'scheduled_date' => $request->scheduled_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'max_participants' => $request->max_participants,
            'duration_hours' => $request->duration_hours,
            'status' => 'planned',
        ]);

        return redirect()->route('hse.training.index')
            ->with('success', "Pelatihan {$training->training_number} telah dijadwalkan.");
    }

    public function show(Training $training)
    {
        $training->load(['division', 'participants.user']);
        return view('hse.training.show', compact('training'));
    }
}
