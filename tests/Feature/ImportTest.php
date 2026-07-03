<?php

use Agicom\Sweepbright\DataObjects\EstateData;
use Agicom\Sweepbright\Sweepbright;
use Agicom\Telemaque\DTOs\AgencyDTO;
use Agicom\Telemaque\DTOs\UserDTO;
use Agicom\Telemaque\Facades\Telemaque;
use Agicom\Telemaque\Resources\AgencyResource;
use App\Contracts\AdvisorRepository;
use App\Contracts\PropertyRepository;
use App\Livewire\Affiches\Editor;
use App\Models\SweepbrightEstate;
use App\Services\Fixtures\FixtureAdvisorRepository;
use App\Services\Fixtures\FixturePropertyRepository;
use App\Services\Sweepbright\AgiprintEstateRepository;
use App\Services\Sweepbright\SweepbrightPropertyRepository;
use App\Services\Telemaque\TelemaqueAdvisorRepository;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

/*
 * Résolution des drivers (services.sweepbright.driver / services.telemaque.driver).
 */
it('binds the fixture repositories by default', function () {
    expect(app(PropertyRepository::class))->toBeInstanceOf(FixturePropertyRepository::class)
        ->and(app(AdvisorRepository::class))->toBeInstanceOf(FixtureAdvisorRepository::class);
});

it('binds the agicom sdk repositories when drivers are set to api', function () {
    config(['services.sweepbright.driver' => 'api', 'services.telemaque.driver' => 'api']);

    expect(app(PropertyRepository::class))->toBeInstanceOf(SweepbrightPropertyRepository::class)
        ->and(app(AdvisorRepository::class))->toBeInstanceOf(TelemaqueAdvisorRepository::class);
});

it('binds the agiprint database repository when the sweepbright driver is agiprint', function () {
    config(['services.sweepbright.driver' => 'agiprint']);

    expect(app(PropertyRepository::class))->toBeInstanceOf(AgiprintEstateRepository::class);
});

/*
 * Éditeur : sélection agence (biens + conseillers chargés au montage).
 */
it('loads the agency estates and advisors on mount', function () {
    Livewire::test(Editor::class)
        ->assertCount('estates', 3)
        ->assertCount('advisors', 3);
});

it('selects an estate and fills the poster fields from sweepbright', function () {
    Livewire::test(Editor::class)
        ->call('selectEstate', 'DEMO-001')
        ->assertSet('selectedEstateId', 'DEMO-001')
        ->assertSet('ville', 'Yerres')
        ->assertSet('prix', 419000)
        ->assertSet('surface', 132)
        ->assertSet('dpe_classe', 'C')
        ->assertSet('statut', 'a_vendre')
        ->assertSet('qr_url', 'https://www.orpi.com/estate/DEMO-001');
});

it('selects an advisor and fills the negotiator block', function () {
    Livewire::test(Editor::class)
        ->call('selectAdvisor', 'thomas.dupond@orpi.com')
        ->assertSet('selectedAdvisorEmail', 'thomas.dupond@orpi.com')
        ->assertSet('agent_nom', 'Thomas Dupond (EI)')
        ->assertSet('agent_telephone', '06 08 04 97 47')
        ->assertSet('agent_visible', true);
});

it('lists fixture estates for an office', function () {
    $items = (new FixturePropertyRepository)->estatesForOffice('any-office');

    expect($items)->toHaveCount(3)
        ->and($items->first()->ville)->toBe('Yerres')
        ->and($items->first()->id)->toBe('DEMO-001');
});

/*
 * Adaptateurs SDK / DB agicom (mapping).
 */
it('maps a sweepbright EstateData (agicom sdk) to poster fields', function () {
    $estate = EstateData::from([
        'type' => 'house',
        'negotiation' => 'sale',
        'status' => 'available',
        'living_rooms' => 1,
        'bedrooms' => 4,
        'sizes' => ['liveable_area' => ['size' => '132.5']],
        'price' => ['amount' => 419000.0],
        'legal' => ['energy' => ['dpe' => 'c', 'epc_value' => 85.0, 'greenhouse_emissions' => 'C', 'co2_emissions' => 15.0]],
        'description_title' => ['fr' => 'Belle maison'],
        'description' => ['fr' => 'Charmante maison.'],
        'location' => ['city' => 'Yerres'],
        'images' => [['url' => 'https://cdn.test/1.jpg']],
        'mandate' => ['number' => 'MDT-1'],
    ]);

    $client = Mockery::mock(Sweepbright::class);
    $client->shouldReceive('get')->once()->with('abc-123')->andReturn($estate);

    $data = (new SweepbrightPropertyRepository($client))->find('abc-123');

    expect($data)->not->toBeNull()
        ->and($data->ville)->toBe('Yerres')
        ->and($data->typeBien)->toBe('Maison')
        ->and($data->pieces)->toBe('5 pièces')
        ->and($data->surface)->toBe(133)
        ->and($data->prix)->toBe(419000)
        ->and($data->dpeClasse)->toBe('C')
        ->and($data->gesValeur)->toBe(15)
        ->and($data->statut)->toBe('a_vendre')
        ->and($data->photoUrl)->toBe('https://cdn.test/1.jpg');
});

it('returns null when sweepbright has no estate', function () {
    $client = Mockery::mock(Sweepbright::class);
    $client->shouldReceive('get')->once()->andReturn(null);

    expect((new SweepbrightPropertyRepository($client))->find('missing'))->toBeNull();
});

it('maps telemaque agency contacts (agicom sdk), skipping inactive advisors', function () {
    $agency = AgencyDTO::fromArray([
        'code' => 'DEMO',
        'contacts' => [
            ['prenom' => 'Thomas', 'nom' => 'Dupond', 'mobile' => '06 08 04 97 47', 'contract_type' => 'Agent Commercial', 'email_orpi' => 't@orpi.com', 'photo_path' => 'https://cdn/t.jpg', 'end_date' => null],
            ['prenom' => 'Ex', 'nom' => 'Parti', 'mobile' => '06 00 00 00 00', 'email_orpi' => 'x@orpi.com', 'end_date' => '2020-01-01'],
        ],
    ]);

    $resource = Mockery::mock(AgencyResource::class);
    $resource->shouldReceive('code')->with('DEMO')->andReturn($agency);
    Telemaque::shouldReceive('agency')->once()->andReturn($resource);

    $advisors = (new TelemaqueAdvisorRepository)->agencyAdvisors('DEMO');

    expect($advisors)->toHaveCount(1)
        ->and($advisors->first()->nom)->toBe('Thomas Dupond (EI)')
        ->and($advisors->first()->telephone)->toBe('06 08 04 97 47')
        ->and($advisors->first()->email)->toBe('t@orpi.com');
});

it('maps a telemaque user by email (agicom sdk)', function () {
    $user = UserDTO::fromArray([
        'prenom' => 'Marie',
        'nom' => 'Lefebvre',
        'mobile' => '06 12 34 56 78',
        'email_orpi' => 'marie@orpi.com',
        'photo_path' => 'https://cdn/m.jpg',
        'end_date' => null,
    ]);

    Telemaque::shouldReceive('user')->once()->with('marie@orpi.com')->andReturn($user);

    $advisor = (new TelemaqueAdvisorRepository)->findByEmail('marie@orpi.com');

    expect($advisor)->not->toBeNull()
        ->and($advisor->nom)->toBe('Marie Lefebvre')
        ->and($advisor->telephone)->toBe('06 12 34 56 78');
});

it('maps an agiprint SweepbrightEstate row (shared DB) to poster fields', function () {
    Storage::fake('estates');

    $estate = (new SweepbrightEstate)->newFromBuilder([
        'id' => 170908,
        'estate_id' => '5d45a91b-cbaf-4a12-a813-c610e6224516',
        'city' => 'Esbly',
        'type' => 'apartment',
        'market_status' => 'sale',
        'price' => '180000',
        'reference' => '12569',
        'email' => 'collivier@orpi.com',
        'title' => json_encode(['fr' => 'Appartement À Vendre']),
        'description' => json_encode(['fr' => 'Bel appartement.']),
        'data' => json_encode([
            'living_rooms' => 1,
            'bedrooms' => 1,
            'sizes' => ['liveable_area' => ['size' => 47]],
            'price' => ['amount' => 180000],
            'legal' => ['energy' => ['dpe' => 'C', 'epc_value' => 162, 'greenhouse_emissions' => 'B', 'co2_emissions' => 6]],
            'mandate' => ['number' => '12569'],
        ]),
    ]);

    $repo = new AgiprintEstateRepository;
    $data = (new ReflectionMethod($repo, 'map'))->invoke($repo, $estate);

    expect($data->ville)->toBe('Esbly')
        ->and($data->typeBien)->toBe('Appartement')
        ->and($data->pieces)->toBe('2 pièces')
        ->and($data->surface)->toBe(47)
        ->and($data->prix)->toBe(180000)
        ->and($data->dpeClasse)->toBe('C')
        ->and($data->gesClasse)->toBe('B')
        ->and($data->accroche)->toBe('Appartement À Vendre')
        ->and($data->statut)->toBe('a_vendre')
        ->and($data->negotiatorEmail)->toBe('collivier@orpi.com')
        ->and($data->propertyUrl)->toBe('https://www.orpi.com/estate/5d45a91b-cbaf-4a12-a813-c610e6224516')
        ->and($data->photoUrl)->toBeNull();
});
