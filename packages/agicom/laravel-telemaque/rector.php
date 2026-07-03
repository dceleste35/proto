<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php84: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: false,
        naming: false,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true,
        carbon: false,
        rectorPreset: false,
        phpunitCodeQuality: true,
    );
