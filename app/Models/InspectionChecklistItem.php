<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionChecklistItem extends Model
{
    protected $fillable = [
        'inspection_id',
        'category',
        'item_description',
        'standard_reference',
        'status',
        'notes',
        'photo',
        'finding_severity',
        'requires_capa',
        'capa_id',
        'checked_by',
        'checked_at',
    ];

    protected $casts = [
        'requires_capa' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function capa()
    {
        return $this->belongsTo(CapaAction::class);
    }

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
