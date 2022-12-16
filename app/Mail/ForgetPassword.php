<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forget-password')
                    ->from(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME'))
                    ->subject('Smavio: Ihr Passwort-Anfragecode lautet: '. $this->data['code'])
                    ->with([
                        'first_name' => $this->data['first_name'],
                        'email' => $this->data['email'],
                        'code' => $this->data['code'],
                    ]);
    }
}
