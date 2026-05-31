<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolboxMeeting extends Model
{
    protected $fillable = [
        'meeting_number',
        'title',
        'topic',
        'work_area_id',
        'division_id',
        'facilitator_id',
        'meeting_date',
        'start_time',
        'end_time',
        'location',
        'agenda',
        'materials_presented',
        'notes',
        'attendance_photo',
        'status',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function facilitator()
    {
        return $this->belongsTo(User::class, 'facilitator_id');
    }

    public function attendances()
    {
        return $this->hasMany(ToolboxAttendance::class);
    }
}
