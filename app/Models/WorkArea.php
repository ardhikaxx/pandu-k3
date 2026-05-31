<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkArea extends Model
{
    protected $fillable = [
        'company_id',
        'division_id',
        'name',
        'code',
        'description',
        'risk_level',
        'location_coordinates',
        'is_active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
