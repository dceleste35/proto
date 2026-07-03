<?php

namespace Agicom\Sweepbright;

use Agicom\Sweepbright\DataObjects\ContactData;
use Agicom\Sweepbright\Http\Requests\GetEstateRequest;
use Agicom\Sweepbright\Http\Requests\PostContactRequest;
use Agicom\Sweepbright\Http\Requests\PostOwnerRequest;
use Agicom\Sweepbright\Http\Requests\SetEstateUrlRequest;
use Agicom\Sweepbright\Http\SweepbrightConnector;

class Sweepbright
{
    public function __construct(protected SweepbrightConnector $connector) {}

    public function get(string $estateId)
    {
        return $this->connector->send(new GetEstateRequest($estateId))->dto();
    }

    public function setUrl(string $estateId)
    {
        $url = route('sweepbright.estate.url', $estateId);

        $this->connector->send(new SetEstateUrlRequest($estateId, $url));
    }

    public function createProspect(ContactData $contactData): bool
    {
        return $this->connector->send(new PostContactRequest($contactData))->successful();
    }

    public function createOwner(ContactData $contactData): bool
    {
        if (is_null($contactData->officeId)) {
            throw new \InvalidArgumentException('office ID cannot be null when creating an owner.');
        }

        return $this->connector->send(new PostOwnerRequest($contactData))->successful();
    }
}
