<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hiradc extends Model
{
    protected $fillable = [
        'document_number',
        'title',
        'work_area_id',
        'division_id',
        'prepared_by',
        'approved_by',
        'revision_number',
        'status',
        'valid_from',
        'valid_until',
        'approved_at',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'approved_at' => 'datetime',
    ];

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(HiradcItem::class);
    }
}
