<?php

namespace Agicom\Telemaque\Http\Requests;

use Agicom\Telemaque\DTOs\AgencyDTO;
use Agicom\Telemaque\Enums\AgencyStatus;
use Agicom\Telemaque\Enums\AgencyType;
use Illuminate\Support\Collection;
use Ramsey\Uuid\UuidInterface;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class GetAgenciesRequest extends Request implements Paginatable
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
    ];

    public function __construct(
        protected ?array $codes = null,
        protected ?string $gie = null,
        protected ?string $siret = null,
        protected ?AgencyType $type = null,
        protected ?AgencyStatus $status = null,
        protected ?UuidInterface $officeId = null,
        protected ?UuidInterface $entityId = null,
        ?array $fields = null
    ) {
        if ($fields !== null) {
            $this->fields = $fields;
        }
    }

    public function resolveEndpoint(): string
    {
        return '/getAgencies';
    }

    protected function defaultQuery(): array
    {
        return [
            'code' => $this->codes,
            'gie' => $this->gie,
            'siret' => $this->siret,
            'type' => $this->type->value ?? null,
            'status' => $this->status->value ?? null,
            'extra:uuidsb' => $this->officeId?->toString(),
            'extra:uuidentitysb' => $this->entityId?->toString(),
            'fields' => implode(',', $this->fields),
        ];
    }

    public function createDtoFromResponse(Response $response): Collection
    {
        $agencies = collect();

        if (! $response->failed()) {
            foreach ($response->json('agencies') as $agency) {
                $agencies->add(AgencyDTO::fromArray($agency));
            }
        }

        return $agencies;
    }
}
