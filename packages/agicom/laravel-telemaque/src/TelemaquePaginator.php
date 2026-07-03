<?php

namespace Agicom\Telemaque;

use Agicom\Telemaque\Http\TelemaqueConnector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\OffsetPaginator;

class TelemaquePaginator extends OffsetPaginator
{
    protected ?int $perPageLimit = 100;

    public function __construct(TelemaqueConnector $connector, Request $request)
    {
        parent::__construct(...func_get_args());
    }

    protected function isLastPage(Response $response): bool
    {
        return $this->getCurrentPage() >= $this->getTotalPages($response);
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->dto()->toArray();
    }

    protected function applyPagination(Request $request): Request
    {
        $request->query()->merge([
            'limit' => $this->perPageLimit,
            'offset' => $this->getOffset(),
        ]);

        return $request;
    }

    protected function getTotalPages(Response $response): int
    {
        return (int) ceil($response->json('results.total') / $this->perPageLimit);
    }
}
