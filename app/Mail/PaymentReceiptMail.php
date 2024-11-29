<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $paymentDetails;

    /**
     * Create a new message instance.
     *
     * @param $booking
     * @param $paymentDetails
     */
    public function __construct($booking, $paymentDetails)
    {
        $this->booking = $booking;
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment-receipt')
                    ->with([
                        'booking' => $this->booking,
                        'paymentDetails' => $this->paymentDetails,
                        'transactionId' => $this->paymentDetails['purchase_units'][0]['payments']['captures'][0]['id'] ?? 'N/A',
                        'amount' => $this->paymentDetails['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? '0.00',
                        'currency' => $this->paymentDetails['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'USD',
                    ]);
    }
    
    
}
