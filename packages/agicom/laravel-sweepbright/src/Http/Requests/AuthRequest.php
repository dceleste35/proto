<?php

namespace Agicom\Sweepbright\Http\Requests;

use Agicom\Sweepbright\DataObjects\ConfigData;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class AuthRequest extends Request implements Cacheable, HasBody
{
    use HasCaching, HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected ConfigData $configData) {}

    public function resolveEndpoint(): string
    {
        return '/oauth/token';
    }

    public function defaultBody(): array
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->configData->clientId,
            'client_secret' => $this->configData->clientSecret,
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store());
    }

    protected function getCacheableMethods(): array
    {
        return [Method::POST];
    }

    public function cacheExpiryInSeconds(): int
    {
        // One week
        return (60 * 60 * 24 * 7) - 1;
    }
}
