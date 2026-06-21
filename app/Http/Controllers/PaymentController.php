<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Support\Str;

    class PaymentController extends Controller
    {
    public function checkout(Booking $booking)
        {
        $payment = $booking->payment;

        if (!$payment) {
        $payment = $booking->payment()->create([
        'amount' => $booking->total_price,
        'currency' => $booking->currency,
        'status' => 'pending',
        'method' => 'mock',
        ]);
        }

    return view('payments.checkout', compact('booking', 'payment'));
    }

    public function pay(Booking $booking)
    {
    $payment = $booking->payment;

    if (!$payment) {
    return redirect()->route('checkout', $booking);
    }

    sleep(2);

    $success = rand(1, 10) > 2;

    if ($success) {

    $payment->update([
    'status' => 'paid',
    'transaction_id' => Str::uuid(),
    ]);

    $booking->update([
    'status' => BookingStatus::PAID,
    ]);

        return redirect()->route('payment.success', $booking);
    }

    $payment->update([
    'status' => 'failed',
    ]);

    $booking->update([
    'status' => BookingStatus::CANCELLED,
    ]);

        return redirect()->route('payment.fail', $booking);
    }

        public function success(Booking $booking)
        {
            return view('payments.success', compact('booking'));
        }

        public function fail(Booking $booking)
        {
            return view('payments.fail', compact('booking'));
        }

}
