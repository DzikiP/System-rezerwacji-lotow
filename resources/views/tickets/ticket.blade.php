<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .box { margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="header">
    <h1>FLIGHT TICKET</h1>
    <h3>{{ $booking->booking_reference }}</h3>
</div>

<div class="box">
    <strong>Status:</strong> {{ $booking->status->value ?? $booking->status }}
</div>

<div class="box">
    <strong>Passengers:</strong><br>

    @foreach($booking->passengers as $p)
        - {{ $p->first_name }} {{ $p->last_name }} ({{ $p->passenger_type }})<br>
    @endforeach
</div>

<div class="box">
    <strong>Flight:</strong><br>

    @php $f = $booking->flight_data; @endphp

    {{ $f['from'] ?? '' }} → {{ $f['to'] ?? '' }}<br>
    {{ $f['flight_number'] ?? '' }}<br>
    {{ $f['airline'] ?? '' }}
</div>

<div class="box">
    <strong>Total:</strong>
    {{ number_format($booking->total_price, 2) }} {{ $booking->currency }}
</div>

<div class="box">
    <strong>Payment:</strong>
    {{ $booking->payment->status ?? 'N/A' }}
</div>

</body>
</html>
