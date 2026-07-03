<?php

use Agicom\Sweepbright\Facades\Sweepbright;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get images collection', function () {
    expect($this->estate->images)->toHaveCount(5);
});

it('can get image data', function () {
    expect($this->estate->images->first()->id)->toBe('91f41342-b176-4f62-9935-a522c24566c7')
        ->and($this->estate->images->first()->url)->not->toBeNull();
});
