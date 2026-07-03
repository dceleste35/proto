<?php

namespace Agicom\Sweepbright;

use Agicom\Sweepbright\Commands\SweepbrightCommand;
use Agicom\Sweepbright\DataObjects\ConfigData;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SweepbrightServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sweepbright')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasRoutes('web')
            ->hasViews()
            ->hasMigration('create_laravel_sweepbright_table')
            ->hasCommand(SweepbrightCommand::class);
    }

    public function bootingPackage()
    {
        $this->app->bind(ConfigData::class, function ($app) {
            return ConfigData::from($app->config->get('sweepbright') ?? []);
        });
    }
}
