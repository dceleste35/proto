<?php

namespace Agicom\Telemaque\Enums;

enum AgencyStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Premember = 'premember';
}
