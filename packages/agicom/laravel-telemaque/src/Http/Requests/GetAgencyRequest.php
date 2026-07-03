<?php

namespace Agicom\Telemaque\Http\Requests;

use Agicom\Telemaque\DTOs\AgencyDTO;
use Ramsey\Uuid\UuidInterface;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAgencyRequest extends Request
{
    protected Method $method = Method::GET;

    public array $fields = [
        'id',
        'id_sweepbright',
        'type',
        'name',
        'address',
        'address_extra',
        'postal_code',
        'city',
        'phone',
        'email',
        'site_internet_orpi',
        'gie',
        'siret',
        'company_name',
        'company_type',
        'capital',
        'rcs',
        'rcs_city',
        'vat_intracommunity',
        'cartepro_number',
        'cartepro_delivered_by',
        'financial_guarantee_name',
        'financial_guarantee_address',
        'financial_guarantee_value',
        'photo_path',
        'contacts',
        'shareholders',
        'responsable_legal',
    ];

    public function __construct(
        protected ?string $code = null,
        protected ?UuidInterface $officeId = null, // officeId is the sweepbright id
        protected ?UuidInterface $legalEntityId = null,
        ?array $fields = null
    ) {
        if ($fields !== null) {
            $this->fields = $fields;
        }
    }

    public function resolveEndpoint(): string
    {
        return '/getAgency';
    }

    protected function defaultQuery(): array
    {
        return [
            'code' => $this->code,
            'extra:uuidsb' => $this->officeId?->toString(),
            'extra:uuidentitysb' => $this->legalEntityId?->toString(),
            'fields' => implode(',', $this->fields),
        ];
    }

    public function createDtoFromResponse(Response $response): ?AgencyDTO
    {
        if ($response->failed()) {
            return null;
        }

        if (empty($response->json('code'))) {
            return null;
        }

        return $response->successful() ? AgencyDTO::fromArray($response->json()) : null;
    }
}
