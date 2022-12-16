<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeviceLogout extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data;
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
        return $this->view('emails.user-device-logout')
            ->from(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME'))
            ->subject('Abmeldung vom Benutzergerät')
            ->with([
                'first_name' => $this->data['first_name'],
                'device'=>$this->data['device']
            ]);
    }
}
