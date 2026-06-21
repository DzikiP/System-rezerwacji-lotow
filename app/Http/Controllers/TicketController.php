<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function generate(Booking $booking)
    {
        $booking->load(['passengers', 'payment']);

        $pdf = Pdf::loadView('tickets.ticket', [
            'booking' => $booking
        ]);

        return $pdf->download('ticket-' . $booking->booking_reference . '.pdf');
    }
}
