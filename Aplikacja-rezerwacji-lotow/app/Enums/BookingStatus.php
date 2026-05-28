<?php

namespace App\Enums;

enum BookingStatus: string
{
    case CONFIRMED = 'confirmed';
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case AWAITING_PAYMENT = 'awaiting_payment';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';

    // =========================
    // LABEL (UI DISPLAY)
    // =========================
    public function label(): string
    {
        return match ($this) {
            self::CONFIRMED => 'Confirmed',
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::AWAITING_PAYMENT => 'Awaiting payment',
            self::PAID => 'Paid',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }

    // =========================
    // UI COLORS (Tailwind)
    // =========================
    public function color(): string
    {
        return match ($this) {
            self::CONFIRMED => 'text-blue-400',
            self::DRAFT => 'text-gray-400',
            self::PENDING => 'text-yellow-400',
            self::AWAITING_PAYMENT => 'text-orange-400',
            self::PAID => 'text-green-400',
            self::CANCELLED => 'text-red-400',
            self::EXPIRED => 'text-gray-500',
        };
    }

    // =========================
    // CHECKERS (opcjonalne ale bardzo wygodne)
    // =========================
    public function isPaid(): bool
    {
        return $this === self::PAID;
    }

    public function isActive(): bool
    {
        return in_array($this, [
            self::CONFIRMED,
            self::PENDING,
            self::AWAITING_PAYMENT,
        ]);
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::PAID,
            self::CANCELLED,
            self::EXPIRED,
        ]);
    }
}
