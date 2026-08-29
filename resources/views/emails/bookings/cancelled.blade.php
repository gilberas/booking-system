<!DOCTYPE html>
<html>
<head><title>Booking Cancelled</title></head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Booking Cancelled</h2>
    <p>Hi <strong>{{ $booking->user->name }}</strong>,</p>
    <p>Your booking at <strong>{{ $booking->hotel->name }}</strong> has been cancelled.</p>

    <table style="border-collapse: collapse; width: 100%; max-width: 500px;">
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Booking #</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->booking_number }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Reason</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->cancellation_reason }}</td></tr>
        <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Refund</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $booking->refund_percentage ?? 0 }}% (${{ number_format($booking->refund_amount ?? 0, 2) }})</td></tr>
    </table>

    @if ($booking->refund_percentage > 0)
        <p>A refund of <strong>${{ number_format($booking->refund_amount, 2) }}</strong> will be processed.</p>
    @endif

    <p style="margin-top: 20px;">
        <a href="{{ route('customer.bookings.show', $booking) }}" style="background: #0d6efd; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">View Details</a>
    </p>

    <p style="color: #666; font-size: 12px; margin-top: 30px;">Booking System</p>
</body>
</html>
