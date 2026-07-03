<?php

namespace Agicom\Telemaque\Casts;

use WendellAdriel\ValidatedDTO\Casting\Castable;

class EmailCast implements Castable
{
    public function cast(string $property, mixed $value): ?string
    {
        return $value === '' ? null : $value;
    }
}
