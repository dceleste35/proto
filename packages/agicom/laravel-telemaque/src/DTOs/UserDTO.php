<?php

namespace Agicom\Telemaque\DTOs;

use Agicom\Telemaque\Casts\EmailCast;
use Agicom\Telemaque\Casts\PermissionsCast;
use Agicom\Telemaque\Casts\PhoneCast;
use Agicom\Telemaque\Enums\Gender;
use Agicom\Telemaque\Traits\ToFillableModel;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use WendellAdriel\ValidatedDTO\Casting\CarbonImmutableCast;
use WendellAdriel\ValidatedDTO\Casting\CollectionCast;
use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class UserDTO extends SimpleDTO
{
    use ToFillableModel;

    public ?int $id = null;

    public ?string $id_sweepbright = null;

    public ?string $name = null;

    public ?CarbonImmutable $start_date = null;

    public ?CarbonImmutable $end_date = null;

    public ?string $contract_type = null;

    public ?string $role = null;

    public ?string $function = null;

    public ?string $permissions = null;

    public ?string $rsac = null;

    public ?string $rsac_city = null;

    public ?string $rsac_postal_code = null;

    public ?string $email_orpi = null;

    public ?string $nom = null;

    public ?string $prenom = null;

    public ?CarbonImmutable $date_of_birth = null;

    public ?string $place_od_birth = null;

    public ?Gender $gender = null;

    public ?string $address = null;

    public ?string $address_extra = null;

    public ?string $photo_path = null;

    public ?string $postal_code = null;

    public ?string $city = null;

    public ?string $country = null;

    public ?string $phone = null;

    public ?string $mobile = null;

    public ?string $email = null;

    public ?string $date_modification = null;

    public ?int $is_deleted = null;

    public ?array $achievements_advisors = null;

    public ?array $achievements_assistants = null;

    public ?Collection $agencies = null;

    /**
     * Defines the default values for the properties of the DTO.
     */
    protected function defaults(): array
    {
        return [];
    }

    /**
     * Defines the type casting for the properties of the DTO.
     */
    protected function casts(): array
    {
        return [
            'email_orpi' => new EmailCast,
            'start_date' => new CarbonImmutableCast,
            'end_date' => new CarbonImmutableCast,
            'date_of_birth' => new CarbonImmutableCast,
            'mobile' => new PhoneCast,
            'phone' => new PhoneCast,
            'gender' => new EnumCast(Gender::class),
            'permissions' => new PermissionsCast,
            'agencies' => new CollectionCast(new DTOCast(AgencyDTO::class)),
        ];
    }

    protected function mapToTransform(): array
    {
        return [
            'id' => 'telemaque_id',
            'id_sweepbright' => 'sweepbright_id',
        ];
    }
}
