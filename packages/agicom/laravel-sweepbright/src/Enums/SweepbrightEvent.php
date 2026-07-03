<?php

namespace Agicom\Sweepbright\Enums;

enum SweepbrightEvent: string
{
    case EstateAdded = 'estate-added';
    case EstateUpdated = 'estate-updated';
    case EstateDeleted = 'estate-deleted';
}
