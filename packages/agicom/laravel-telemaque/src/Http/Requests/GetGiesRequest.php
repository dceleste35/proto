<?php

namespace Agicom\Telemaque\Http\Requests;

use Agicom\Telemaque\DTOs\GieDTO;
use Agicom\Telemaque\Enums\GieStatus;
use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGiesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected ?string $code = null) {}

    public function resolveEndpoint(): string
    {
        return '/getGies';
    }

    protected function defaultQuery(): array
    {
        return [
            'code' => $this->code,
            'status' => GieStatus::Active->value,
        ];
    }

    public function createDtoFromResponse(Response $response): Collection
    {
        $gies = collect();

        if (! $response->failed()) {
            foreach ($response->json('gies') as $gie) {
                $gies->add(GieDTO::fromArray($gie));
            }
        }

        return $gies;
    }
}
