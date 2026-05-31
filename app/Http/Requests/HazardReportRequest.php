<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HazardReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => 'required|string|min:10|max:200',
            'description'     => 'required|string|min:20',
            'work_area_id'    => 'required|exists:work_areas,id',
            'hazard_type'     => 'required|in:unsafe_condition,unsafe_act,near_miss',
            'category'        => 'required|in:electrical,mechanical,chemical,fire,ergonomic,biological,other',
            'severity'        => 'required|in:low,medium,high,critical',
            'location_detail' => 'required|string|max:200',
            'photos'          => 'required|array|min:1|max:5',
            'photos.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB
        ];
    }
}
