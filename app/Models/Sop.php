<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sop extends Model
{
    protected $fillable = [
        'document_number',
        'title',
        'category',
        'content',
        'work_area_id',
        'division_id',
        'created_by',
        'approved_by',
        'version',
        'status',
        'effective_date',
        'review_date',
        'document_path',
        'view_count',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'review_date' => 'date',
    ];

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
