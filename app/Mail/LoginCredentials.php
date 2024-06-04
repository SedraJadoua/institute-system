<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginCredentials extends Mailable
{
    use Queueable, SerializesModels;
 
    public $userName , $password;
    /**
     * Create a new message instance.
     */
    public function __construct($userName , $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }
    public function build()
    {
        return $this->markdown('credentials');
    }
}
