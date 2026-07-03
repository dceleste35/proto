<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get location data', function () {
    expect($this->estate->location->city)->toBe('Paris')
        ->and($this->estate->location->postalCode)->toBe('75010')
        ->and($this->estate->location->latitude)->toBe(48.87285929999999)
        ->and($this->estate->location->longitude)->toBe(2.3750922);
});
