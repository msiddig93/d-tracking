<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ?? 'N/A',
            'email' => $this->email ?? 'N/A',
            'phone' => $this->phone ?? 'N/A',
            // Add more fields as needed
        ];
    }
}
