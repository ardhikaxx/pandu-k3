<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'industry_type',
        'logo',
        'phone',
        'email',
        'is_active',
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function workAreas()
    {
        return $this->hasMany(WorkArea::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
