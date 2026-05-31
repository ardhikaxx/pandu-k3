<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapaAction extends Model
{
    protected $fillable = [
        'capa_number',
        'source_type',
        'source_id',
        'title',
        'description',
        'action_type',
        'priority',
        'assigned_to',
        'assigned_by',
        'division_id',
        'due_date',
        'status',
        'progress_notes',
        'completion_evidence',
        'completed_at',
        'verified_by',
        'verified_at',
        'effectiveness_rating',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completion_evidence' => 'array',
        'completed_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function source()
    {
        return $this->morphTo(null, 'source_type', 'source_id');
    }
}
