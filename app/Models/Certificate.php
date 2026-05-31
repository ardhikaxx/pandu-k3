<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_type',
        'certificate_number',
        'issuing_body',
        'issued_date',
        'expiry_date',
        'status',
        'document_path',
        'reminder_sent_at',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
        'reminder_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
