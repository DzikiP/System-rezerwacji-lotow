<?php

namespace App\Enums;

enum BookingStatus:string
{
    case CONFIRMED = 'CONFIRMED';
    case DRAFT = 'draft';
    case Pending = 'pending';
    case AwaitingPayment = 'awaiting_payment';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
}
