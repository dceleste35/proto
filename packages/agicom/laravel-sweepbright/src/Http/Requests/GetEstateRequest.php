<?php

namespace Agicom\Sweepbright\Http\Requests;

use Agicom\Sweepbright\DataObjects\EstateData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetEstateRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $estateId) {}

    public function resolveEndpoint(): string
    {
        return "/estates/{$this->estateId}";
    }

    public function createDtoFromResponse(Response $response): ?EstateData
    {
        if ($response->successful()) {
            return EstateData::from($response->array());
        }

        return null;
    }
}
