<?php

namespace Agicom\Telemaque\DTOs;

use Agicom\Telemaque\Casts\PhoneCast;
use Agicom\Telemaque\Enums\AgencyStatus;
use Agicom\Telemaque\Enums\AgencyType;
use Agicom\Telemaque\Traits\ToFillableModel;
use Illuminate\Support\Collection;
use WendellAdriel\ValidatedDTO\Casting\CollectionCast;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class AgencyDTO extends SimpleDTO
{
    use ToFillableModel;

    public ?int $id = null;

    public ?string $id_sweepbright = null;

    public ?AgencyType $type = null;

    public ?AgencyStatus $status = null;

    public ?string $name = null;

    public ?string $code = null;

    public ?string $company_name = null;

    public ?string $address = null;

    public ?string $address_extra = null;

    public ?string $postal_code = null;

    public ?string $country_code = null;

    public ?string $city = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $site_internet_orpi = null;

    public ?string $gie = null;

    public ?string $siret = null;

    public ?string $photo_path = null;

    public ?string $company_type = null;

    public ?int $capital = null;

    public ?string $rcs = null;

    public ?string $rcs_city = null;

    public ?string $vat_intracommunity = null;

    public ?string $cartepro_number = null;

    public ?string $cartepro_delivered_by = null;

    public ?string $financial_guarantee_name = null;

    public ?string $financial_guarantee_address = null;

    public ?int $financial_guarantee_value = null;

    public ?Collection $contacts = null;

    public ?Collection $shareholders = null;

    public ?Collection $other_agencies = null;

    public ?Collection $responsable_legal;

    /**
     * Defines the type casting for the properties of the DTO.
     */
    protected function casts(): array
    {
        return [
            'type' => new EnumCast(AgencyType::class),
            'status' => new EnumCast(AgencyStatus::class),
            'phone' => new PhoneCast,
            'capital' => new IntegerCast,
            'financial_guarantee_value' => new IntegerCast,
            'contacts' => new CollectionCast(new DTOCast(UserDTO::class)),
            'shareholders' => new CollectionCast(new DTOCast(UserDTO::class)),
            'other_agencies' => new CollectionCast(new DTOCast(AgencyDTO::class)),
            'responsable_legal' => new CollectionCast(new DTOCast(OtherContactDTO::class)),
        ];
    }

    protected function mapToTransform(): array
    {
        return [
            'id' => 'telemaque_id',
            'id_sweepbright' => 'sweepbright_id',
        ];
    }

    protected function defaults(): array
    {
        return [
            'country_code' => $this->getCountryCode($this->postal_code),
        ];
    }

    protected function getCountryCode($postal_code): ?string
    {
        if ($postal_code) {
            return match (substr((string) $postal_code, 0, 3)) {
                '971' => 'GP',
                '972' => 'MQ',
                '973' => 'GF',
                '974' => 'RE',
                '975' => 'PM',
                '976' => 'YT',
                '977' => 'BL',
                '978' => 'MF',
                '986' => 'WF',
                '987' => 'PF',
                '988' => 'NC',
                '984' => 'TF',
                default => 'FR',
            };
        }

        return null;
    }
}
