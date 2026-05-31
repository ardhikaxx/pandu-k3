<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApdInventory extends Model
{
    protected $fillable = [
        'item_code',
        'name',
        'category',
        'brand',
        'model',
        'size',
        'work_area_id',
        'division_id',
        'total_quantity',
        'available_quantity',
        'damaged_quantity',
        'standard_reference',
        'inspection_interval_days',
        'last_inspected_at',
        'next_inspection_date',
        'condition',
        'notes',
    ];

    protected $casts = [
        'last_inspected_at' => 'date',
        'next_inspection_date' => 'date',
    ];

    public function workArea()
    {
        return $this->belongsTo(WorkArea::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
