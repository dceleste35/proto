<?php

namespace Agicom\Sweepbright\Enums;

use Agicom\Sweepbright\Enums\Concerns\HasFurnishedLabel;
use Agicom\Sweepbright\Enums\Concerns\HasLabel;

enum Type: string
{
    use HasFurnishedLabel;
    use HasLabel;

    case House = 'house';
    case Apartment = 'apartment';
    case Parking = 'parking';
    case Land = 'land';
    case Commercial = 'commercial';
    case Office = 'office';

    public function upper()
    {
        return strtoupper($this->value);
    }
}
