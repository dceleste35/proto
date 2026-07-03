<?php

namespace Agicom\Sweepbright\DataObjects\Estate;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class LocationData extends Data
{
    public ?string $city;

    #[MapInputName('postal_code')]
    #[MapOutputName('postal_code')]
    public ?string $postalCode;

    #[MapInputName('geo.latitude')]
    #[MapOutputName('geo.latitude')]
    public ?float $latitude;

    #[MapInputName('geo.longitude')]
    #[MapOutputName('geo.longitude')]
    public ?float $longitude;

    #[MapInputName('geo.hidden')]
    #[MapOutputName('geo.hidden')]
    public ?bool $hidden;
}
