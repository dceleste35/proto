<?php

namespace Agicom\Sweepbright\DataObjects\Estate;

use Agicom\Sweepbright\DataObjects\Concerns\HasTranslations;
use Spatie\LaravelData\Data;
use Stringable;

class DescriptionData extends Data implements Stringable
{
    use HasTranslations;

    public function __construct(
        public ?string $fr,
        public ?string $en,
        public ?string $nl,
    ) {}
}
