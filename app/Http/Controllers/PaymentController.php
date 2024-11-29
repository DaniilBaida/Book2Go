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
        try {
            // Initialize PayPal client
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);
    
            // Capture payment details
            $response = $provider->capturePaymentOrder($request->token);
    
            // Log PayPal response for debugging
            \Log::info('PayPal Response:', $response);
    
            // Verifique se a resposta contém as chaves corretas
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Acesse corretamente os dados de pagamento
                $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? '0.00';
                $currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'USD';
                $transactionId = $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? 'N/A';
    
                // Save payment details
                Payment::create([
                    'booking_id' => $booking->id,
                    'transaction_id' => $transactionId,
                    'gateway' => 'paypal',
                    'amount' => $amount,
                    'currency' => $currency,
                ]);
    
                // Update booking status to 'paid'
                $booking->update(['status' => 'paid']);
    
                // Send payment receipt email
                \Mail::to($booking->user->email)->send(new \App\Mail\PaymentReceiptMail($booking, $response));
    
                return redirect()->route('client.bookings')->with('success', 'Payment successful. Booking confirmed.');
            }
    
            return redirect()->route('client.bookings')->with('error', 'Payment failed. Please try again.');
        } catch (\Exception $e) {
            \Log::error('Payment Error: ' . $e->getMessage());
    
            return redirect()->route('client.bookings')->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }
    
    

    public function cancel(Booking $booking)
    {
        // Update booking status to 'canceled'
        $booking->update(['status' => 'canceled']);
        return redirect()->route('client.bookings')->with('error', 'Payment canceled.');
    }
}
