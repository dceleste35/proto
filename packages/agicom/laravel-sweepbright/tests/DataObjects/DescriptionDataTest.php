<?php

use Agicom\Sweepbright\DataObjects\Estate\DescriptionData;
use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get description data', function () {
    expect($this->estate->description->fr)->toBe('Apartement à vendre')
        ->and($this->estate->description->en)->toBe('Apartment for sale')
        ->and($this->estate->description->nl)->toBe('Frishtèèth');
});

it('can get locale', function () {
    expect($this->estate->description->locale('fr'))->toBe('Apartement à vendre')
        ->and($this->estate->description->locale('en'))->toBe('Apartment for sale')
        ->and($this->estate->description->locale('nl'))->toBe('Frishtèèth');
});

it('uses app locale when no argument is given', function () {
    app()->setLocale('nl');
    expect($this->estate->description->locale())->toBe('Frishtèèth');
});

it('falls back to english for unknown locale', function () {
    expect($this->estate->description->locale('de'))->toBe('Apartment for sale');
});

it('falls back to app fallback locale when primary locale is null', function () {
    $data = DescriptionData::from(['fr' => 'Bonjour', 'en' => null, 'nl' => null]);
    app()->setLocale('en');
    config()->set('app.fallback_locale', 'fr');

    expect($data->locale())->toBe('Bonjour');
});

it('falls back to first non-null value as last resort', function () {
    $data = DescriptionData::from(['fr' => null, 'en' => null, 'nl' => 'Hallo']);

    expect($data->locale('de'))->toBe('Hallo');
});

it('can be used as a string', function () {
    app()->setLocale('fr');

    expect((string) $this->estate->description)->toBe('Apartement à vendre');
});

it('returns empty string when all locales are null', function () {
    $data = DescriptionData::from(['fr' => null, 'en' => null, 'nl' => null]);

    expect((string) $data)->toBe('');
});
