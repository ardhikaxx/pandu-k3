<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HiradcRequest extends FormRequest
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
            'title' => 'required|string|max:200',
            'work_area_id' => 'required|exists:work_areas,id',
            'division_id' => 'required|exists:divisions,id',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'items' => 'required|array|min:3',
            'items.*.activity' => 'required|string',
            'items.*.hazard_description' => 'required|string',
            'items.*.hazard_type' => 'required|in:physical,chemical,biological,ergonomic,psychosocial,mechanical,electrical,fire,environmental',
            'items.*.potential_incident' => 'required|string',
            'items.*.severity_before' => 'required|integer|between:1,5',
            'items.*.probability_before' => 'required|integer|between:1,5',
            'items.*.control_hierarchy' => 'required|in:elimination,substitution,engineering,administrative,ppe',
            'items.*.control_measures' => 'required|string',
            'items.*.pic_control' => 'required|string',
            'items.*.target_date' => 'required|date',
            'items.*.severity_after' => 'required|integer|between:1,5',
            'items.*.probability_after' => 'required|integer|between:1,5',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($this->input('items', []) as $index => $item) {
                $scoreBefore = ($item['severity_before'] ?? 0) * ($item['probability_before'] ?? 0);
                $scoreAfter = ($item['severity_after'] ?? 0) * ($item['probability_after'] ?? 0);

                if ($scoreAfter >= $scoreBefore && $scoreBefore > 0) {
                    $validator->errors()->add("items.{$index}.severity_after", "Skor risiko setelah kontrol ({$scoreAfter}) harus lebih kecil dari skor sebelum kontrol ({$scoreBefore}).");
                }
            }
        });
    }
}
