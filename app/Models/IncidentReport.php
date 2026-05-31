<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    protected $fillable = [
        'report_number',
        'reporter_id',
        'victim_name',
        'victim_employee_id',
        'work_area_id',
        'division_id',
        'incident_type',
        'incident_date',
        'incident_time',
        'title',
        'description',
        'immediate_cause',
        'root_cause',
        'injuries_description',
        'body_part_affected',
        'property_damage_description',
        'estimated_loss',
        'witnesses',
        'photos',
        'status',
        'severity_classification',
        'investigated_by',
        'investigation_report',
        'lost_time_days',
        'corrective_actions',
        'preventive_actions',
        'capa_id',
        'submitted_at',
        'closed_at',
    ];

    protected $casts = [
        'witnesses' => 'array',
        'photos' => 'array',
        'incident_date' => 'date',
        'submitted_at' => 'datetime',
        'closed_at' => 'datetime',
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

    public function investigatedBy()
    {
        return $this->belongsTo(User::class, 'investigated_by');
    }

    public function capa()
    {
        return $this->belongsTo(CapaAction::class, 'capa_id');
    }
}
