<?php

namespace Agicom\Sweepbright\Http\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class SetEstateUrlRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected string $estateId,
        protected string $url,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/estates/{$this->estateId}/url";
    }

    public function defaultBody(): array
    {
        return ['url' => $this->url];
    }
}
