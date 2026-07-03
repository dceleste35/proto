<?php

namespace Agicom\Sweepbright\Enums;

use Agicom\Sweepbright\Enums\Concerns\HasLabel;

enum MarketStatus: string
{
    use HasLabel;

    case Sale = 'sale';
    case Let = 'let';
    case Sold = 'sold';
    case Rented = 'rented';
    case Agreement = 'agreement';
}
