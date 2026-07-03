<?php

namespace App\Providers;

use App\Contracts\AdvisorRepository;
use App\Contracts\PropertyRepository;
use App\Services\Fixtures\FixtureAdvisorRepository;
use App\Services\Fixtures\FixturePropertyRepository;
use App\Services\Sweepbright\AgiprintEstateRepository;
use App\Services\Sweepbright\SweepbrightPropertyRepository;
use App\Services\Telemaque\TelemaqueAdvisorRepository;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PropertyRepository::class, fn () => match (config('services.sweepbright.driver')) {
            'agiprint' => new AgiprintEstateRepository,   // base partagée agiprint (comme qr-switch)
            'api' => new SweepbrightPropertyRepository,    // SDK agicom/laravel-sweepbright
            default => new FixturePropertyRepository,       // démo sans credentials
        });

        $this->app->bind(AdvisorRepository::class, fn () => config('services.telemaque.driver') === 'api'
            ? new TelemaqueAdvisorRepository
            : new FixtureAdvisorRepository);
    }
}
