$<?php

use Agicom\Sweepbright\Facades\Sweepbright;
use Agicom\Sweepbright\Http\Requests\AuthRequest;
use Agicom\Sweepbright\Http\Requests\GetEstateRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('can get estate', function () {

    MockClient::global([
        AuthRequest::class => MockResponse::fixture('auth'),
        GetEstateRequest::class => MockResponse::fixture('get-estate'),
    ]);

    $estateData = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');

    expect($estateData->id)->toBe('78ea08c2-25d6-4167-a362-683d94b2d1ef');

});

it('can get program', function () {

    MockClient::global([
        AuthRequest::class => MockResponse::fixture('auth'),
        GetEstateRequest::class => MockResponse::fixture('get-estates'),
    ]);

    $estateData = Sweepbright::get('c5ac358a-f41a-4d35-a5b8-a51a758e4d9a');

    expect($estateData->id)->toBe('c5ac358a-f41a-4d35-a5b8-a51a758e4d9a');

});
