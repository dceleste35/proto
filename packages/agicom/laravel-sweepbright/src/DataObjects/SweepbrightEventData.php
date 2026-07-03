<?php

namespace Agicom\Sweepbright\DataObjects;

use Agicom\Sweepbright\Enums\SweepbrightEvent;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class SweepbrightEventData extends Data
{
    public function __construct(
        public SweepbrightEvent $event,

        #[MapInputName('estate_id')]
        #[MapOutputName('estate_id')]
        public string $estateId,

        #[WithCast(DateTimeInterfaceCast::class)]
        #[MapInputName('happened_at')]
        #[MapOutputName('happened_at')]
        public CarbonImmutable $happenedAt,

        #[MapInputName('company_id')]
        #[MapOutputName('company_id')]
        public string $companyId,
    ) {}
}
