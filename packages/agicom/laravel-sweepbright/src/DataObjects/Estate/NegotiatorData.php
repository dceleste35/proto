<?php

namespace Agicom\Sweepbright\DataObjects\Estate;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class NegotiatorData extends Data
{
    public ?int $id;

    #[MapInputName('first_name')]
    #[MapOutputName('first_name')]
    public ?string $firstName;

    #[MapInputName('last_name')]
    #[MapOutputName('last_name')]
    public ?string $lastName;

    public ?string $email;

    public ?string $phone;

    #[MapInputName('photo_url')]
    #[MapOutputName('photo_url')]
    public ?string $photoUrl;
}
