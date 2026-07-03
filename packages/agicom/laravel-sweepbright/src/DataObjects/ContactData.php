<?php

namespace Agicom\Sweepbright\DataObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class ContactData extends Data
{
    public function __construct(
        #[MapInputName('first_name')]
        #[MapOutputName('first_name')]
        public string $firstName,

        #[MapInputName('last_name')]
        #[MapOutputName('last_name')]
        public string $lastName,

        public string $email,

        public string $phone,

        public string $message,

        public ?string $locale,

        #[MapInputName('property_id')]
        #[MapOutputName('property_id')]
        public ?string $propertyId,

        #[MapInputName('office_id')]
        #[MapOutputName('office_id')]
        public ?string $officeId,
    ) {}
}
