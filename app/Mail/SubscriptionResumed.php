<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionResumed extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

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
        return $this->view('emails.subscription-resumed')
            ->from(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME'))
            ->subject('Ihr Abonnementplan wurde bei Smavio fortgesetzt!')
            ->with([
                'first_name' => $this->data['first_name'],
                'plan' => $this->data['plan']
            ]);
    }
}
