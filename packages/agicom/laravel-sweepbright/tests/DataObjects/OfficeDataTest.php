<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get office data', function () {
    expect($this->estate->office->id)->toBe('c60d46dd-c839-4c7d-b6e1-627e1c9da22f')
        ->and($this->estate->office->name)->toBe('Orpi');
});
