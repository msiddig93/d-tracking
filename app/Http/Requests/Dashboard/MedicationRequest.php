<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'name' => 'required|string|max:255',
            'reminder_time' => 'required', // Consider 'date_format:H:i' if only time, or 'date' if datetime
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
