<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;


    public $order;

    // Constructor to pass order data
    public function __construct($order)
    {
        $this->order = $order;
    }

    // Build the message
    public function build()
    {
        return $this->subject('Payment Successful')
                    ->view('emails.payment_success')  // Define a view for the email
                    ->with(['order' => $this->order]);
    }

}

