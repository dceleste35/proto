<?php

namespace Agicom\Telemaque\Casts;

use WendellAdriel\ValidatedDTO\Casting\Castable;

class PhoneCast implements Castable
{
    public function cast(string $property, mixed $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        $firstChar = substr((string) $value, 0, 1);

        if ($firstChar === '+') {
            $value = preg_replace('/^\+33|^(\+262)|^(\+590)|^(\+596)|^(\+594)/', '0', (string) $value);
        }

        return preg_replace('/[^0-9]/', '', (string) $value);
    }
}
