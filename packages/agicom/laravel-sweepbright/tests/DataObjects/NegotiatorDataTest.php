<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get negotiator data', function () {
    expect($this->estate->negotiator->firstName)->toBe('Damien')
        ->and($this->estate->negotiator->lastName)->toBe('Orts')
        ->and($this->estate->negotiator->email)->toBe('dortsOLD@orpi.com')
        ->and($this->estate->negotiator->photoUrl)->toBeNull();
});
