<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    /**
     * Get a list of all the values
     *
     * @return array
     */
    public static function values()
    {
        return [
            self::Low->value,
            self::Medium->value,
            self::High->value
        ];
    }
}
