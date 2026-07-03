<?php

namespace Agicom\Sweepbright\Events;

use Agicom\Sweepbright\DataObjects\SweepbrightEventData;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EstateUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public SweepbrightEventData $sweepbrightEventData) {}
}
