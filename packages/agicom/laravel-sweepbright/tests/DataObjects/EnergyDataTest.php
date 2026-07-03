<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get energy data', function () {
    expect($this->estate->energy->dpe)->toBe('B')
        ->and($this->estate->energy->epcValue)->toBe(100.0)
        ->and($this->estate->energy->co2Emissions)->toBe(200.0)
        ->and($this->estate->energy->greenhouseEmissions)->toBe('C');
});
