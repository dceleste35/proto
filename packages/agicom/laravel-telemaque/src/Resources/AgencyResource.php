<?php

namespace Agicom\Telemaque\Resources;

use Agicom\Telemaque\DTOs\AgencyDTO;
use Agicom\Telemaque\Enums\AgencyType;
use Agicom\Telemaque\Http\Requests\GetAgenciesRequest;
use Agicom\Telemaque\Http\Requests\GetAgencyRequest;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Saloon\Http\BaseResource;

class AgencyResource extends BaseResource
{
    public function code($code, $filtered = false): mixed
    {
        return $this->connector->send(
            new GetAgencyRequest(code: $code)
        )->dto();
    }

    public function officeId(string $officeId): mixed
    {
        return $this->connector->send(
            new GetAgencyRequest(officeId: Uuid::fromString($officeId))
        )->dto();
    }

    public function legalEntityId(string $legalEntityId): ?AgencyDTO
    {
        return $this->connector->send(
            new GetAgencyRequest(legalEntityId: Uuid::fromString($legalEntityId)))->dto();
    }

    public function legal(string $legalEntityId, string $officeId): ?AgencyDTO
    {
        $legalAgency = $this->connector->send(new GetAgencyRequest(
            legalEntityId: Uuid::fromString($legalEntityId)
        ))->dto();

        if ($legalAgency) {
            return $legalAgency;
        }

        $agencies = $this->connector->send(new GetAgenciesRequest(
            officeId: Uuid::fromString($officeId)
        ))->dto();

        if ($agencies->count() === 1) {
            return $agencies->first();
        }

        /** @var Collection $agencies description */
        if ($agencies->count() > 1) {
            return $agencies->where('type', AgencyType::Primary)->first();
        }

        return null;
    }
}
