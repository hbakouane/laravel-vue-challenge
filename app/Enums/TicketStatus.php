<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Closed = 'closed';

    public static function toSelectArray(): array
    {
        return [
            self::Open->value => self::Open->name,
            self::InProgress->value => self::InProgress->name,
            self::Closed->value => self::Closed->name,
        ];
    }

    /**
     * Get a list of all the values
     *
     * @return array
     */
    public static function values()
    {
        return [
            self::Open->value,
            self::InProgress->value,
            self::Closed->value
        ];
    }
}
