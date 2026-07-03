<?php

use Agicom\Sweepbright\Enums\MarketStatus;
use Agicom\Sweepbright\Enums\Status;
use Agicom\Sweepbright\Enums\SubType;
use Agicom\Sweepbright\Enums\Type;
use Illuminate\Support\Facades\App;

it('can test', function () {
    expect(true)->toBeTrue();
});

it('can get type label', function () {
    $type = Type::from('apartment');
    expect($type)->toBeInstanceOf(Type::class);
    expect($type->value)->toBe('apartment');
    expect($type->getLabel())->toBe('Apartment');
    expect($type->getLabel('fr'))->toBe('Appartement');
    expect($type->getLabel('nl'))->toBe('Appartement');
    App::setLocale('fr');
    expect($type->getLabel())->toBe('Appartement');
});

it('can get type furnished label', function () {
    $type = Type::House;
    expect($type->getFurnishedLabel())->toBe('Furnished House');
    expect($type->getFurnishedLabel('fr'))->toBe('Maison meublée');
    expect($type->getFurnishedLabel('nl'))->toBe('Gemeubileerd huis');
});

it('can get sub type label', function () {
    $subType = SubType::from('chalet_alpine');
    expect($subType->getLabel())->toBe('Chalet alpine');
    expect($subType->getLabel('fr'))->toBe('Chalet alpin');
    expect($subType->getLabel('nl'))->toBe('Alpine chalet');
});

it('can get sub type furnished label', function () {
    $subType = SubType::Villa;
    expect($subType->getFurnishedLabel())->toBe('Furnished Villa');
    expect($subType->getFurnishedLabel('fr'))->toBe('Villa meublée');
    expect($subType->getFurnishedLabel('nl'))->toBe('Gemeubileerde villa');
});

it('can get status label', function () {
    $status = Status::from('agreement');
    expect($status)->toBeInstanceOf(Status::class);
    expect($status->value)->toBe('agreement');
    expect($status->getLabel())->toBe('Agreement');
    App::setLocale('fr');
    expect($status->getLabel())->toBe('Sous compromis');
});

it('can get market status label', function () {
    $marketStatus = MarketStatus::from('sale');
    expect($marketStatus)->toBeInstanceOf(MarketStatus::class);
    expect($marketStatus->value)->toBe('sale');
    expect($marketStatus->getLabel())->toBe('Sale');
    App::setLocale('fr');
    expect($marketStatus->getLabel())->toBe('À vendre');
});

it('falls back to generated label for unsupported locale', function () {
    $type = Type::House;
    expect($type->getLabel('be'))->toBe('House');

    $subType = SubType::ChaletAlpine;
    expect($subType->getLabel('be'))->toBe('Chalet alpine');
});

it('can get nl translations', function () {
    App::setLocale('nl');
    expect(Type::House->getLabel())->toBe('Huis');
    expect(Status::Available->getLabel())->toBe('Beschikbaar');
    expect(MarketStatus::Sale->getLabel())->toBe('Te koop');
});
