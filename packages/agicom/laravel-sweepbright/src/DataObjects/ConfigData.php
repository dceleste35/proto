<?php

namespace Agicom\Sweepbright\DataObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class ConfigData extends Data
{
    public function __construct(
        #[MapInputName('client_id')]
        public string $clientId,

        #[MapInputName('client_secret')]
        public string $clientSecret,

        #[MapInputName('api_version')]
        public string $apiVersion,

        #[MapInputName('base_url')]
        public string $baseUrl,
    ) {}

    protected function rules(): array
    {
        return [
            'client_id' => ['required', 'integer'],
            'client_secret' => ['required', 'string', 'uuid'],
            'api_version' => ['required', 'string'],
            'base_url' => ['required', 'string', 'url'],
        ];
    }
}
