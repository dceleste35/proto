<?php

use Agicom\Sweepbright\Http\Requests\AuthRequest;
use Agicom\Sweepbright\Http\Requests\GetEstateRequest;
use Agicom\Sweepbright\Tests\TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

pest()
    ->extend(TestCase::class)
    ->use(LazilyRefreshDatabase::class)
    ->in(__DIR__);

uses()
    ->beforeEach(function () {
        MockClient::global([
            AuthRequest::class => MockResponse::fixture('auth'),
            GetEstateRequest::class => MockResponse::fixture('get-estate'),
        ]);
    })
    ->in('DataObjects');
