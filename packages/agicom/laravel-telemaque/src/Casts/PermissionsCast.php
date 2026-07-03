<?php

namespace Agicom\Telemaque\Casts;

use WendellAdriel\ValidatedDTO\Casting\Castable;

class PermissionsCast implements Castable
{
    public function cast(string $property, mixed $value): ?string
    {
        return $value[0] ?? null;
    }
}
