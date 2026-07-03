<?php

use Agicom\Sweepbright\DataObjects\ConfigData;

it('can config data', function () {
    $configData = ConfigData::from(config('sweepbright'));

    expect($configData)->toBeInstanceOf(ConfigData::class);
    expect($configData->clientId)->toBeString();
    expect($configData->clientSecret)->toBeString();
    expect($configData->baseUrl)->toBeString();
    expect($configData->apiVersion)->toBeString();
});
