<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlucoseTest extends Model
{
    protected $table = 'glucose_tests';

    protected $fillable = [
        'patient_id',
        'test_date',
        'level',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFormattedTestTimeAttribute(){
    return $this->test_date
            ? \Carbon\Carbon::parse($this->test_date)->format('M d-y h:i A')
            : null;
    }
}
