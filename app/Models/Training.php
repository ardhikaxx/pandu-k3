<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'training_number',
        'title',
        'type',
        'description',
        'provider',
        'trainer_name',
        'trainer_credential',
        'division_id',
        'scheduled_date',
        'end_date',
        'location',
        'max_participants',
        'duration_hours',
        'status',
        'materials_url',
        'certificate_issued',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'end_date' => 'date',
        'certificate_issued' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function participants()
    {
        return $this->hasMany(TrainingParticipant::class);
    }
}
