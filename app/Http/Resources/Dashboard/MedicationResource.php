<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'name' => $this->name,
            'reminder_time' => $this->reminder_time,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'status' => $this->is_active ? 'Active' : 'Inactive',
            'status_colors' => $this->is_active
                ? ['#D1FAE5', '#065F46'] // green background, green text
                : ['#FEE2E2', '#991B1B'], // red background, red text
            'patient' => $this->patient,
            'created_at' => $this->created_at->format('M d-Y H:i A'),
            // Add calculated fields here later
        ];
    }
}
