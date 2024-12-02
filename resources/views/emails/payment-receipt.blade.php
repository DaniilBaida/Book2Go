<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="background-color: #ffffff; border: 1px solid #e5e5e5; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); padding: 20px; max-width: 600px; margin: 20px auto;">
    
        <h1 style="font-size: 24px; font-weight: bold; text-align: center; color: #2563eb; margin-bottom: 20px;">Book2Go Services</h1>
        <p style="font-size: 16px; text-align: center; color: #333333;">Thank you for your payment! Here are the details of your booking:</p>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #e5e5e5;">
        
        <div style="margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: bold; color: #333333;">Invoice:</h2>
            <div style="color: #555555;">
                <p>Date: {{ $booking->date->format('d/m/Y') }}</p>
                <p>Invoice #: {{ $transactionId }}</p>
                <p>Service #: {{ $booking->service->name }}</p>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: bold; color: #333333;">Details:</h2>
            <div style="margin-bottom: 20px;">
                <p style="color: #555555;">Name: {{ $booking->user->name }}</p>
                <p style="color: #555555;">Time: {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                <p style="color: #555555;">Status: {{ ucfirst($booking->status) }}</p>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="text-align: left; font-weight: bold; color: #555555; border-bottom: 1px solid #e5e5e5; padding-bottom: 5px;">Service</th>
                    <th style="text-align: right; font-weight: bold; color: #555555; border-bottom: 1px solid #e5e5e5; padding-bottom: 5px;">Amount</th>
                    <th style="text-align: right; font-weight: bold; color: #555555; border-bottom: 1px solid #e5e5e5; padding-bottom: 5px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left; color: #555555; padding: 10px 0;">{{ $booking->service->name }}</td>
                    <td style="text-align: right; color: #555555; padding: 10px 0;">{{ $amount }} {{ $currency }}</td>
                    <td style="text-align: right; color: #555555; padding: 10px 0;">{{ ucfirst($booking->status) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: left; font-weight: bold; color: #333333; padding-top: 10px;">Total</td>
                    <td style="text-align: right; font-weight: bold; color: #333333; padding-top: 10px;">{{ $amount }} {{ $currency }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <p style="color: #555555; margin-top: 20px;">Thank you for your business!</p>
    </div>
</body>
</html>
