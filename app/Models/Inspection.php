<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $fillable = [
        'inspection_number',
        'title',
        'inspection_type',
        'work_area_id',
        'division_id',
        'inspector_id',
        'scheduled_date',
        'actual_date',
        'status',
        'completion_percentage',
        'overall_notes',
        'photos',
        'completed_at',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'actual_date' => 'date',
        'photos' => 'array',
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

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function checklistItems()
    {
        return $this->hasMany(InspectionChecklistItem::class);
    }
}
