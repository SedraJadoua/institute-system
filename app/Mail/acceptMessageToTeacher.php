<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class acceptMessageToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    
    public $userName , $courseName;
    /**
     * Create a new message instance.
     */
    public function __construct($userName , $courseName)
    {
        $this->userName = $userName;
        $this->courseName = $courseName;
    }
    public function build()
    {
        return $this->markdown('accept-to-teacher');
    }
}
