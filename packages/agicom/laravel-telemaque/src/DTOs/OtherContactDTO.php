<?php

namespace Agicom\Telemaque\DTOs;

use Agicom\Telemaque\Traits\ToFillableModel;
use WendellAdriel\ValidatedDTO\SimpleDTO;

class OtherContactDTO extends SimpleDTO
{
    use ToFillableModel;

    public ?string $lastname;

    public ?string $firstname;

    public ?string $email;

    public ?string $email_orpi;

    public ?string $address;

    public ?string $address_extra;

    public ?string $city;

    public ?string $postal_code;

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
