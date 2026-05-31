<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HazardReport extends Model
{
    protected $fillable = [
        'report_number',
        'reporter_id',
        'work_area_id',
        'division_id',
        'hazard_type',
        'category',
        'title',
        'description',
        'location_detail',
        'coordinates',
        'severity',
        'photos',
        'status',
        'priority',
        'assigned_to',
        'verified_by',
        'verified_at',
        'resolved_at',
        'closed_at',
        'response_time_minutes',
        'supervisor_notes',
        'resolution_notes',
        'capa_id',
        'reported_at',
    ];

    protected $casts = [
        'photos' => 'array',
        'verified_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'reported_at' => 'datetime',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function capa()
    {
        return $this->belongsTo(CapaAction::class, 'capa_id');
    }
}
