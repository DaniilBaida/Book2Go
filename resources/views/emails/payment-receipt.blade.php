<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body>
    <h1>Payment Receipt</h1>
    <p>Dear {{ $booking->user->name }},</p>

    <p>Thank you for your payment! Here are the details of your booking:</p>

    <table>
        <tr>
            <th>Service:</th>
            <td>{{ $booking->service->name }}</td>
        </tr>
        <tr>
            <th>Date:</th>
            <td>{{ $booking->date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Time:</th>
            <td>{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ ucfirst($booking->status) }}</td>
        </tr>
    </table>

    <h3>Payment Details</h3>
    <ul>
        <li>Transaction ID: {{ $transactionId }}</li>
        <li>Amount: {{ $amount }} {{ $currency }}</li>
        <li>Status: Completed</li>
    </ul>

    <p>If you have any questions, feel free to contact us.</p>

    <p>Thank you,</p>
    <p>Book2Go</p>
</body>
</html>
