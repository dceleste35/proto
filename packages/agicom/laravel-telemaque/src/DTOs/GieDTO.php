<?php

namespace Agicom\Telemaque\DTOs;

use Agicom\Telemaque\Casts\PhoneCast;
use Agicom\Telemaque\Traits\ToFillableModel;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use WendellAdriel\ValidatedDTO\Casting\CarbonImmutableCast;
use WendellAdriel\ValidatedDTO\Casting\CollectionCast;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class GieDTO extends SimpleDTO
{
    use ToFillableModel;

    public ?string $name = null;

    public ?string $code = null;

    public ?string $status = null;

    public ?CarbonImmutable $date_network_entry = null;

    public ?CarbonImmutable $date_network_exit = null;

    public ?string $address = null;

    public ?string $address_extra = null;

    public ?string $postal_code = null;

    public ?string $city = null;

    public ?string $country = null;

    public ?string $country_code = null;

    public ?string $phone = null;

    public ?string $fax = null;

    public ?string $email = null;

    public ?string $siret = null;

    public ?Collection $contacts = null;

    /**
     * Defines the type casting for the properties of the DTO.
     */
    protected function casts(): array
    {
        return [
            'phone' => new PhoneCast,
            'date_network_entry' => new CarbonImmutableCast,
            'date_network_exit' => new CarbonImmutableCast,
            'contacts' => new CollectionCast(new DTOCast(UserDTO::class)),
        ];
    }

    protected function mapToTransform(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }
}
