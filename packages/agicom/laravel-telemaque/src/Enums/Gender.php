<?php

namespace Agicom\Telemaque\Enums;

enum Gender: string
{
    case Sir = 'M.';
    case Mrs = 'Mme';
    case Miss = 'Mlle';

    public function sex(): string
    {
        return match ($this) {
            self::Sir => 'man',
            self::Mrs, self::Miss => 'women',
        };
    }
}
