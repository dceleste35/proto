<?php

namespace Agicom\Telemaque\Resources;

use Agicom\Telemaque\Enums\AgencyStatus;
use Agicom\Telemaque\Http\Requests\GetAgenciesRequest;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;
use Saloon\Http\BaseResource;
use Saloon\PaginationPlugin\OffsetPaginator;

class AgenciesResource extends BaseResource
{
    protected AgencyStatus $status = AgencyStatus::Active;

    public function status(AgencyStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function codes(array $codes): Collection
    {
        return $this->connector
            ->send(new GetAgenciesRequest(
                codes: $codes,
                status: $this->status
            ))->dto();
    }

    public function gie(string $gie): Collection
    {
        return $this->connector
            ->send(new GetAgenciesRequest(
                gie: $gie,
                status: $this->status
            ))->dto();
    }

    public function officeId(string $officeId): Collection
    {
        $officeId = Uuid::fromString($officeId);

        return $this->connector
            ->send(new GetAgenciesRequest(
                officeId: $officeId
            ))->dto();
    }

    public function page(int $page = 1, int $number = 100): Collection
    {
        $paginator = $this->connector
            ->paginate(new GetAgenciesRequest(status: $this->status)) // @phpstan-ignore method.notFound
            ->setStartPage($page)
            ->setMaxPages($page)
            ->setPerPageLimit($number);

        $orders = collect();
        foreach ($paginator->items() as $order) {
            $orders->add($order);
        }

        return $orders;
    }

    public function all(): OffsetPaginator
    {
        return $paginator = $this->connector
            ->paginate(new GetAgenciesRequest( // @phpstan-ignore method.notFound
                status: $this->status,
            ));
    }
}
