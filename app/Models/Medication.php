<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medications';

    protected $fillable = [
        'patient_id',
        'name',
        'reminder_time',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the patient that owns the medication.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
