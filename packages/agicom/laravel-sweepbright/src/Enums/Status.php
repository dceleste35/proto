<?php

namespace Agicom\Sweepbright\Enums;

use Agicom\Sweepbright\Enums\Concerns\HasLabel;

enum Status: string
{
    use HasLabel;

    case Prospect = 'prospect';
    case UnderContract = 'under_contract';
    case Available = 'available';
    case Option = 'option';
    case Agreement = 'agreement';
    case Sale = 'sale';
    case Let = 'let';
    case Sold = 'sold';
    case Rented = 'rented';
    case Lost = 'lost';
}
