<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubUserInvitationMail extends Mailable
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
        return $this->view('emails.subuser-invitation')
            ->from(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME'))
            ->subject($this->data['user']->first_name . ' hat Sie zum Mitmachen eingeladen ' . $this->data['user']->company_name . ' bei Smavi.')
            ->with([
                'user' => $this->data['user'],
                'invitee' => $this->data['invitee'],
            ]);
    }
}
