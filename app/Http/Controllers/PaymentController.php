<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function success(Request $request, Booking $booking)
    {
        // Initialize PayPal client
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        // Capture payment details
        $response = $provider->capturePaymentOrder($request->token);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Save payment details
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'transaction_id' => $response['id'],
                'gateway' => 'paypal',
            ]);

            // Update booking status
            $booking->update(['status' => 'accepted']);

            return redirect()->route('client.bookings')->with('success', 'Payment successful. Booking confirmed.');
        }

        return redirect()->route('client.bookings')->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'canceled']);
        return redirect()->route('client.bookings')->with('error', 'Payment canceled.');
    }
}
