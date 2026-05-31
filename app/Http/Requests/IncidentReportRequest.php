<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IncidentReportRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:200',
            'incident_date' => 'required|date|before_or_equal:today',
            'incident_time' => 'required',
            'work_area_id' => 'required|exists:work_areas,id',
            'incident_type' => 'required|in:accident,near_miss,first_aid,medical_treatment,lost_time,fatality',
            'description' => 'required|string|min:20',
            'victim_name' => 'nullable|string|max:100',
            'victim_employee_id' => 'nullable|string|max:20',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ];

        // Restriction for Worker role
        if (auth()->user()->role === 'worker') {
            $rules['severity_classification'] = 'required|in:minor,moderate';
            $rules['incident_type'] = 'required|in:near_miss,first_aid';
        } else {
            $rules['severity_classification'] = 'required|in:minor,moderate,serious,major,catastrophic';
        }

        return $rules;
    }
}
