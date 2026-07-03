<?php

namespace Agicom\Sweepbright\DataObjects\Estate;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class EnergyData extends Data
{
    public ?string $dpe;

    #[MapInputName('greenhouse_emissions')]
    #[MapOutputName('greenhouse_emissions')]
    public ?string $greenhouseEmissions;

    #[MapInputName('epc_value')]
    #[MapOutputName('epc_value')]
    public ?float $epcValue;

    #[MapInputName('co2_emissions')]
    #[MapOutputName('co2_emissions')]
    public ?float $co2Emissions;
}
