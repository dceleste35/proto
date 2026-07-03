<?php

namespace Agicom\Sweepbright\DataObjects;

use Agicom\Sweepbright\DataObjects\Estate\DescriptionData;
use Agicom\Sweepbright\DataObjects\Estate\DescriptionTitleData;
use Agicom\Sweepbright\DataObjects\Estate\EnergyData;
use Agicom\Sweepbright\DataObjects\Estate\ImageData;
use Agicom\Sweepbright\DataObjects\Estate\LocationData;
use Agicom\Sweepbright\DataObjects\Estate\MandateData;
use Agicom\Sweepbright\DataObjects\Estate\NegotiatorData;
use Agicom\Sweepbright\DataObjects\Estate\OfficeData;
use Agicom\Sweepbright\DataObjects\Estate\Source;
use Agicom\Sweepbright\Enums\MarketStatus;
use Agicom\Sweepbright\Enums\Status;
use Agicom\Sweepbright\Enums\SubType;
use Agicom\Sweepbright\Enums\Type;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class EstateData extends Data
{
    #[Computed]
    #[MapOutputName('market_status')]
    public ?MarketStatus $marketStatus;

    #[Computed]
    #[MapOutputName('room_count')]
    public ?int $roomCount;

    // public ?Source $source;

    // public ?float $buyer_percentage;

    // public ?float $vendor_percentage;

    // public ?float $vendor_fixed_fee;

    // public ?float $buyer_fixed_fee;

    public function __construct(
        public ?string $id,

        #[MapInputName('is_project')]
        #[MapOutputName('is_project')]
        public ?bool $isProject,

        #[MapInputName('project_id')]
        #[MapOutputName('project_id')]
        public ?string $projectId,

        public ?OfficeData $office,

        public ?Type $type,

        #[MapInputName('sub_type')]
        #[MapOutputName('sub_type')]
        public ?SubType $subType,

        public ?Status $status,

        public ?string $negotiation,

        #[MapInputName('legal.energy')]
        public ?EnergyData $energy,

        #[MapInputName('living_rooms')]
        #[MapOutputName('living_rooms')]
        public ?int $livingRooms,

        public ?int $bedrooms,

        public ?int $kitchens,

        #[MapInputName('sizes.liveable_area.size')]
        public ?string $surface,

        #[MapInputName('price.amount')]
        public ?float $amount,

        #[MapInputName('description_title')]
        public ?DescriptionTitleData $title,

        public ?DescriptionData $description,

        #[DataCollectionOf(EstateData::class)]
        public ?Collection $properties,

        #[DataCollectionOf(ImageData::class)]
        public ?Collection $images,

        public ?NegotiatorData $negotiator,

        public ?LocationData $location,

        public ?MandateData $mandate,

    ) {
        $this->marketStatus = $this->getMarketStatus();
        $this->roomCount = $this->getRoomCount();
    }

    /**
     * This return the state of the estate base either on
     * the status or the negotiation the negotiation
     * determines if this is a sale or a rent
     */
    public function getMarketStatus(): ?MarketStatus
    {
        return match (true) {
            $this->status === Status::Sold,
            $this->status === Status::Rented,
            $this->status === Status::Agreement => MarketStatus::tryFrom($this->status->value),

            default => $this->negotiation ? MarketStatus::tryFrom($this->negotiation) : null,
        };
    }

    public function getRoomCount(): ?int
    {
        return $this->livingRooms + $this->bedrooms;
    }
}

// 'roomCount' => $this->living_rooms + $this->bedrooms,
//     'dpe' => $this->energy->dpe ?? null,
//     'surface' => $this->liveable_area['size'] ?? null,
