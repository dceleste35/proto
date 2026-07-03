<?php

use Agicom\Sweepbright\DataObjects\EstateData;
use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can hydrate estate data', function () {
    expect($this->estate)->toBeInstanceOf(EstateData::class)
        ->and($this->estate->id)->toBe('78ea08c2-25d6-4167-a362-683d94b2d1ef')
        ->and($this->estate->isProject)->toBeFalse()
        ->and($this->estate->projectId)->toBeNull()
        ->and($this->estate->negotiation)->toBe('sale')
        ->and($this->estate->type->value)->toBe('apartment')
        ->and($this->estate->status->value)->toBe('available');
});

it('can get market status', function () {
    expect($this->estate->marketStatus->value)->toBe('sale');
});

it('can get room count', function () {
    expect($this->estate->roomCount)->toBe(2)
        ->and($this->estate->livingRooms)->toBe(1)
        ->and($this->estate->bedrooms)->toBe(1)
        ->and($this->estate->kitchens)->toBe(1);
});

it('can get price', function () {
    expect($this->estate->amount)->toBe(380000.0);
});

it('can get surface', function () {
    expect($this->estate->surface)->toBe('19');
});
