<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OneTimePasswordMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your One-Time Password')->view('Emails.otp')
            ->with([
                'otp' => $this->user->otp,
                'name' => $this->user->name,
            ]);
    }
}
