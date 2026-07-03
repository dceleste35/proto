<?php

namespace Agicom\Telemaque\Http\Requests;

use Agicom\Telemaque\DTOs\UserDTO;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Symfony\Component\Mime\Address;

class GetUserRequest extends Request
{
    protected Method $method = Method::GET;

    public array $fields = [
        'id',
        'email_orpi',
        'gender',
        'prenom',
        'nom',
        'phone',
        'mobile',
        'address',
        'postal_code',
        'city',
        'photo_path',
        'rsac',
        'rsac_city',
        'rsac_postal_code',
        'id_sweepbright',
        'type',
        'name',
        'address_extra',
        'email',
        'site_internet_orpi',
        'gie',
        'siret',
        'company_name',
        'company_type',
        'capital',
        'rcs',
        'vat_intracommunity',
        'cartepro_number',
        'cartepro_delivered_by',
        'financial_guarantee_name',
        'financial_guarantee_address',
        'financial_guarantee_value',
        'status',
    ];

    public function __construct(
        protected Address $email,
        ?array $fields = null
    ) {
        if ($fields !== null) {
            $this->fields = $fields;
        }
    }

    public function resolveEndpoint(): string
    {
        return '/getUser';
    }

    protected function defaultQuery(): array
    {
        return [
            'email' => $this->email->getAddress(),
            'fields' => implode(',', $this->fields),
        ];
    }

    public function createDtoFromResponse(Response $response): ?UserDTO
    {
        if ($response->failed()) {
            return null;
        }

        return $response->successful() ? UserDTO::fromArray($response->json()) : null;
    }
}
