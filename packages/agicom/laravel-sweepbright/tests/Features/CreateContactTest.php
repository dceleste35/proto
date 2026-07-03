<?php

use Agicom\Sweepbright\DataObjects\ContactData;
use Agicom\Sweepbright\Facades\Sweepbright;
use Agicom\Sweepbright\Http\Requests\AuthRequest;
use Agicom\Sweepbright\Http\Requests\PostContactRequest;
use Agicom\Sweepbright\Http\Requests\PostOwnerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('can create prospect', function () {

    MockClient::global([
        AuthRequest::class => MockResponse::fixture('auth'),
        PostContactRequest::class => MockResponse::fixture('post-contact'),
    ]);

    $contactData = ContactData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1234567890',
        'message' => 'I am interested in your services.',
        'locale' => 'en',
        'property_id' => null,
        'office_id' => null,
    ]);

    $result = Sweepbright::createProspect($contactData);

    expect($result)->toBeTrue();

});

it('can create owner', function () {

    MockClient::global([
        AuthRequest::class => MockResponse::fixture('auth'),
        PostOwnerRequest::class => MockResponse::fixture('post-owner'),
    ]);

    $contactData = ContactData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1234567890',
        'message' => 'I am interested in your services.',
        'locale' => 'en',
        'property_id' => null,
        'office_id' => 'bfb7cef0-aedb-4eef-93e4-d2eea8e61059',
    ]);

    $result = Sweepbright::createOwner($contactData);

    expect($result)->toBeTrue();

});

it('can not create owner if office ID is null', function () {

    $contactData = ContactData::from([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1234567890',
        'message' => 'I am interested in your services.',
        'property_id' => null,
    ]);

    Sweepbright::createOwner($contactData);

})->throws(InvalidArgumentException::class, 'office ID cannot be null when creating an owner.');
