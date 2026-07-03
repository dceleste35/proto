<?php

use Agicom\Sweepbright\Facades\Sweepbright;
use Carbon\CarbonImmutable;

beforeEach(function () {
    $this->estate = Sweepbright::get('78ea08c2-25d6-4167-a362-683d94b2d1ef');
});

it('can get mandate data', function () {
    expect($this->estate->mandate->number)->toBe('5432')
        ->and($this->estate->mandate->exclusive)->toBeTrue()
        ->and($this->estate->mandate->startDate)->toBeInstanceOf(CarbonImmutable::class)
        ->and($this->estate->mandate->startDate->format('Y-m-d'))->toBe('2025-10-14')
        ->and($this->estate->mandate->endDate)->toBeInstanceOf(CarbonImmutable::class)
        ->and($this->estate->mandate->endDate->format('Y-m-d'))->toBe('2025-10-31');
});

it('computes duration in days', function () {
    expect($this->estate->mandate->duration)->toBe(17);
});
