<?php

namespace App\Enums;

enum FlightStatus:int
{
    case Cancelled = 0;
    case Scheduled = 1; // الحالة الافتراضية
    case Delayed = 2;

    public function label(): string
    {
        return match ($this) {
            FlightStatus::Cancelled => 'Cancelled',
            FlightStatus::Scheduled => 'On Schedule',
            FlightStatus::Delayed => 'Delayed',
        };
    }
}
