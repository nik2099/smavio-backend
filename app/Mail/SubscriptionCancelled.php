<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionCancelled extends Mailable
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
        return $this->view('emails.subscription-cancelled')
            ->from(config('MAIL_FROM_ADDRESS'), config('MAIL_FROM_NAME'))
            ->subject('Ihr Abonnement bei Smavio wurde gekündigt!')
            ->with([
                'first_name' => $this->data['first_name'],
                'plan' => $this->data['plan']
            ]);
    }
}
