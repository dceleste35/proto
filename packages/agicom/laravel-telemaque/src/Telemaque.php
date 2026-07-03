<?php

namespace Agicom\Telemaque;

use Agicom\Telemaque\Http\Requests\GetUserRequest;
use Agicom\Telemaque\Http\TelemaqueConnector;
use Agicom\Telemaque\Resources\AgenciesResource;
use Agicom\Telemaque\Resources\AgencyResource;
use Agicom\Telemaque\Resources\GieResource;
use Symfony\Component\Mime\Address;

class Telemaque
{
    public function __construct(public TelemaqueConnector $connector) {}

    public function agency(): AgencyResource
    {
        return new AgencyResource($this->connector);
    }

    public function agencies(): AgenciesResource
    {
        return new AgenciesResource($this->connector);
    }

    public function gie(): GieResource
    {
        return new GieResource($this->connector);
    }

    public function user(string $email): mixed
    {
        return $this->connector->send(new GetUserRequest(new Address($email)))->dto();
    }
}
