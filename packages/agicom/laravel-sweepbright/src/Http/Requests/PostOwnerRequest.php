<?php

namespace Agicom\Sweepbright\Http\Requests;

use Agicom\Sweepbright\DataObjects\ContactData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PostOwnerRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected ContactData $contactData) {}

    public function defaultBody(): array
    {
        return $this->contactData->toArray();
    }

    public function resolveEndpoint(): string
    {
        return '/contacts/owners';
    }
}
