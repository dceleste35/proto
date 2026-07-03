<?php

use Agicom\Sweepbright\DataObjects\SweepbrightEventData;
use Agicom\Sweepbright\Enums\SweepbrightEvent;
use Agicom\Sweepbright\Events\EstateAdded;
use Agicom\Sweepbright\Events\EstateDeleted;
use Agicom\Sweepbright\Events\EstateUpdated;
use Agicom\Sweepbright\Facades\Sweepbright;
use Agicom\Sweepbright\Http\Middleware\SweepbrightMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function Illuminate\Support\defer;

Route::prefix('sweepbright')
    ->name('sweepbright.')
    ->group(function () {
        Route::post('/webhook', function (Request $request) {

            defer(
                callback: function () use ($request) {
                    $sweepbrightEventData = SweepbrightEventData::from($request->all());

                    Sweepbright::setUrl($sweepbrightEventData->estateId);

                    match ($sweepbrightEventData->event) {
                        SweepbrightEvent::EstateAdded => EstateAdded::dispatch($sweepbrightEventData),
                        SweepbrightEvent::EstateUpdated => EstateUpdated::dispatch($sweepbrightEventData),
                        SweepbrightEvent::EstateDeleted => EstateDeleted::dispatch($sweepbrightEventData),
                    };
                },
                always: true
            );

            return response(status: 200);

        })
            ->name('webhook')
            ->middleware(SweepbrightMiddleware::class);

        Route::get('estate/{estate}', function ($estateId) {
            return redirect()->route('estate.show', $estateId);
        })->name('estate.url');
    });
