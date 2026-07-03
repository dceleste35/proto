<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get description title data', function () {
    expect($this->estate->title->fr)->toBe('Apartment à vendre')
        ->and($this->estate->title->en)->toBe('Apartment à vendre')
        ->and($this->estate->title->nl)->toBe('Apartment à vendre');
});

it('can be used as a string', function () {
    app()->setLocale('fr');

    expect((string) $this->estate->title)->toBe('Apartment à vendre');
});
