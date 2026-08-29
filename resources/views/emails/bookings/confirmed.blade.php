<!DOCTYPE html>
<html>
<head><title>Booking Confirmed</title></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Booking Confirmed!</h2>
    <p>Hi <strong>{{ $booking->user->name }}</strong>,</p>
    <p>Your booking at <strong>{{ $booking->hotel->name }}</strong> is confirmed.</p>

    <table style="border-collapse: collapse; width: 100%; max-width: 500px;">
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Booking #</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->booking_number }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Hotel</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->hotel->name }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Check-in</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->check_in->format('M d, Y') }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Check-out</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->check_out->format('M d, Y') }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Total</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">${{ number_format($booking->total_amount, 2) }}</td></tr>
        <tr><td style="padding: 8px;"><strong>Status</strong></td><td style="padding: 8px;">{{ ucfirst($booking->status) }}</td></tr>
    </table>

    <p style="margin-top: 20px;">
        <a href="{{ route('customer.bookings.show', $booking) }}" style="background: #0d6efd; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">View Booking</a>
    </p>

    <p style="color: #666; font-size: 12px; margin-top: 30px;">Booking System</p>
</body>
</html>
