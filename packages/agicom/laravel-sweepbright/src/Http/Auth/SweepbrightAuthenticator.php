<?php

namespace Agicom\Sweepbright\Http\Auth;

use Agicom\Sweepbright\DataObjects\ConfigData;
use Agicom\Sweepbright\Http\Requests\AuthRequest;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class SweepbrightAuthenticator implements Authenticator
{
    public function __construct(protected ConfigData $configData) {}

    public function set(PendingRequest $pendingRequest): void
    {
        // Make sure to ignore the authentication request to prevent loops.
        if ($pendingRequest->getRequest() instanceof AuthRequest) {
            return;
        }

        // Make a request to the Authentication endpoint using the same connector.
        $response = $pendingRequest->getConnector()->send(new AuthRequest($this->configData));

        // Finally, authenticate the previous PendingRequest before it is sent.
        $pendingRequest->headers()->add('Authorization', 'Bearer '.$response->json('access_token'));
    }
}
