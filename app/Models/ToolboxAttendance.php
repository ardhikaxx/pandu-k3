<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolboxAttendance extends Model
{
    protected $fillable = [
        'toolbox_meeting_id',
        'user_id',
        'attendance_status',
        'signature_path',
    ];

    public function meeting()
    {
        return $this->belongsTo(ToolboxMeeting::class, 'toolbox_meeting_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
