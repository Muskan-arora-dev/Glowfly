<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SupplierCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $supplier;
    public $username;
    public $password;

    public function __construct(User $supplier, $username, $password)
    {
        $this->supplier = $supplier;
        $this->username = $username;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Supplier Account Credentials')
                    ->view('emails.supplier_credentials');
    }
}
