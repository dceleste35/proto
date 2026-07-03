<?php

namespace Agicom\Sweepbright\DataObjects\Estate;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class MandateData extends Data
{
    #[Computed]
    public ?int $duration;

    public function __construct(
        public ?string $number,

        public ?bool $exclusive,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[MapInputName('start_date')]
        #[MapOutputName('start_date')]
        public ?CarbonImmutable $startDate,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[MapInputName('end_date')]
        #[MapOutputName('end_date')]
        public ?CarbonImmutable $endDate,
    ) {
        $this->duration = ($this->startDate && $this->endDate)
            ? (int) $this->startDate->diffInDays($this->endDate)
            : 0;
    }
}
