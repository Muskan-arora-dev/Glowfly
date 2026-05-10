<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryRequestSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // user data

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('GlowFly Delivery Partner Request')
                    ->view('emails.delivery_request_submitted');
    }
}
