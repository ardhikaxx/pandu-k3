<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingParticipant extends Model
{
    protected $fillable = [
        'training_id',
        'user_id',
        'registration_status',
        'pre_test_score',
        'post_test_score',
        'certificate_issued',
        'certificate_path',
        'notes',
    ];

    protected $casts = [
        'certificate_issued' => 'boolean',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
