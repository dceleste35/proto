<?php

namespace Agicom\Telemaque\Enums;

enum AgencyType: string
{
    case Primary = 'a';
    case Branch = 's';
    case FirstBranch = 'f';
    case SeasonalBranch = 't';
    case VirtualBranch = 'v';

    public function label(): string
    {
        return match ($this) {
            self::Primary => 'principale',
            self::Branch => 'succursale',
            self::FirstBranch => '1 ère succursale',
            self::SeasonalBranch => 'succursale saisonnière',
            self::VirtualBranch => 'succursale virtuelle',
        };
    }
}
