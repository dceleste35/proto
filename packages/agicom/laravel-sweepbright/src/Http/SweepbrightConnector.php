<?php

namespace Agicom\Sweepbright\Http;

use Agicom\Sweepbright\DataObjects\ConfigData;
use Agicom\Sweepbright\Http\Auth\SweepbrightAuthenticator;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class SweepbrightConnector extends Connector
{
    use AcceptsJson;

    public function __construct(protected ConfigData $configData) {}

    public function defaultAuth(): ?Authenticator
    {
        return new SweepbrightAuthenticator($this->configData);
    }

    public function resolveBaseUrl(): string
    {
        return $this->configData->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.sweepbright.v'.$this->configData->apiVersion.'+json',
        ];
    }
}
