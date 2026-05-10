<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // must be public to access in Blade

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->markdown('emails.delivery.approved')
                    ->subject('🎉 Your Delivery Partner Request is Approved!');
    }
}
