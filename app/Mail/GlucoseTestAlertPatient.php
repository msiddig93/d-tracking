<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GlucoseTestAlertPatient extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;
    public $glucoseTest;
    public $levelStatus;

    /**
     * Create a new message instance.
     */
    public function __construct($doctor, $glucoseTest, $levelStatus)
    {
        $this->doctor = $doctor;
        $this->glucoseTest = $glucoseTest;
        $this->levelStatus = $levelStatus; // 'high' or 'low'
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.glucose_test_alert_patient')
            ->subject('Glucose Test Alert: '.ucfirst($this->levelStatus).' Level');
    }
}
