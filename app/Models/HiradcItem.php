<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiradcItem extends Model
{
    protected $fillable = [
        'hiradc_id',
        'activity',
        'hazard_description',
        'hazard_type',
        'potential_incident',
        'severity_before',
        'probability_before',
        'risk_score_before',
        'risk_level_before',
        'control_hierarchy',
        'control_measures',
        'pic_control',
        'target_date',
        'severity_after',
        'probability_after',
        'risk_score_after',
        'risk_level_after',
        'residual_risk_acceptable',
    ];

    protected $casts = [
        'target_date' => 'date',
        'residual_risk_acceptable' => 'boolean',
    ];

    public function hiradc()
    {
        return $this->belongsTo(Hiradc::class);
    }
}
