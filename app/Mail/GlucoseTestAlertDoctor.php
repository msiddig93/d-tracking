<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GlucoseTestAlertDoctor extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;
    public $glucoseTest;
    public $levelStatus;

    /**
     * Create a new message instance.
     */
    public function __construct($patient, $glucoseTest, $levelStatus)
    {
        $this->patient = $patient;
        $this->glucoseTest = $glucoseTest;
        $this->levelStatus = $levelStatus; // 'high' or 'low'
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.glucose_test_alert_doctor')
            ->subject('Patient Glucose Test Alert: '.ucfirst($this->levelStatus).' Level');
    }
}
