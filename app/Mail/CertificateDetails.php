<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer_name;
    public $buyer_surname;
    public $tree;
    public $amount;
    public $cost;
    public $activation_key;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($buyer_name, $buyer_surname, $tree, $amount, $cost, $activation_key)
    {
        $this->buyer_name = $buyer_name;
        $this->buyer_surname = $buyer_surname;
        $this->tree = $tree;
        $this->amount = $amount;
        $this->cost = $cost;
        $this->activation_key = $activation_key;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.certificate-details');
    }
}
