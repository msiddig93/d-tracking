<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlucoseTest extends Model
{
    protected $table = 'glucose_tests';

    protected $fillable = [
        'patient_id',
        'test_date',
        'level',
        'notes',
        'is_fasting',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_colors', 'fasting'];

    public function getFormattedTestTimeAttribute(){
        return $this->test_date
                ? \Carbon\Carbon::parse($this->test_date)->format('M d-y h:i A')
                : null;
    }

    /**
     * Get the fasting
     *
     * @return string
     */
    public function getFastingAttribute()
    {
        return $this->is_fasting ? 'Fasting' : 'Not Fasting';
    }

    /**
     * Get the status_colors
     *
     * @return string
     */
    public function getStatusColorsAttribute()
    {
        return $this->is_fasting
                ? ['#D1FAE5', '#065F46'] // green background, green text
                : ['#FEE2E2', '#991B1B'];
    }

    /**
     * Get the patient that owns the GlucoseTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withDefault();
    }
}
