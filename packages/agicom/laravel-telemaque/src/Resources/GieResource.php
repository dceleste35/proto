<?php

namespace Agicom\Telemaque\Resources;

use Agicom\Telemaque\DTOs\GieDTO;
use Agicom\Telemaque\Http\Requests\GetGiesRequest;
use Illuminate\Support\Collection;
use Saloon\Http\BaseResource;

class GieResource extends BaseResource
{
    public function code($code): ?GieDTO
    {
        return $this->connector->send(
            new GetGiesRequest(code: $code)
        )->dto()->first();
    }

    public function all(): Collection
    {
        return $this->connector->send(
            new GetGiesRequest
        )->dto();
    }
}
