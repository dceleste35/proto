<?php

namespace Agicom\Telemaque\Http;

use Agicom\Telemaque\TelemaquePaginator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\OffsetPaginator;
use Saloon\Traits\Plugins\AcceptsJson;

class TelemaqueConnector extends Connector implements HasPagination
{
    use AcceptsJson;

    public function boot(PendingRequest $pendingRequest): void
    {
        $pendingRequest->authenticate(new TokenAuthenticator(config('telemaque.token', 'Bearer')));
    }

    public function resolveBaseUrl(): string
    {
        return config('telemaque.base_url').'/api/'.config('telemaque.api_version');
    }

    public function paginate(Request $request): OffsetPaginator
    {
        return new TelemaquePaginator($this, $request);
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return ! is_null($response->json('error'));
    }
}
