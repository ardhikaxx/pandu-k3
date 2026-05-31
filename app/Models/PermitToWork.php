<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermitToWork extends Model
{
    protected $fillable = [
        'permit_number',
        'work_type',
        'title',
        'description',
        'work_area_id',
        'division_id',
        'applicant_id',
        'supervisor_id',
        'approved_by',
        'start_datetime',
        'end_datetime',
        'required_ppe',
        'precautions',
        'emergency_contacts',
        'hazards_identified',
        'control_measures',
        'status',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'required_ppe' => 'array',
        'emergency_contacts' => 'array',
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
