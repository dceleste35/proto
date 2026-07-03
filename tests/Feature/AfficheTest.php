<?php

use App\Enums\Statut;
use App\Livewire\Affiches\Editor;
use App\Livewire\Affiches\Index;
use App\Models\Affiche;
use Livewire\Livewire;
use Spatie\LaravelPdf\Facades\Pdf;

use function Pest\Laravel\get;

it('redirects home to the affiches list', function () {
    get('/')->assertRedirect(route('affiches.index'));
});

it('lists affiches on the index page', function () {
    $affiche = Affiche::factory()->create(['ville' => 'Rennes']);

    Livewire::test(Index::class)
        ->assertOk()
        ->assertSee('Rennes')
        ->assertSee($affiche->badgeLabel());
});

it('creates an affiche through the editor', function () {
    Livewire::test(Editor::class)
        ->set('ville', 'Yerres')
        ->set('type_bien', 'Maison')
        ->set('prix', 419000)
        ->set('dpe_classe', 'C')
        ->set('ges_classe', 'C')
        ->set('statut', 'a_vendre')
        ->call('save')
        ->assertHasNoErrors();

    expect(Affiche::where('ville', 'Yerres')->exists())->toBeTrue();
});

it('requires a city', function () {
    Livewire::test(Editor::class)
        ->set('ville', '')
        ->call('save')
        ->assertHasErrors(['ville' => 'required']);
});

it('loads an existing affiche into the editor', function () {
    $affiche = Affiche::factory()->create([
        'ville' => 'Nantes',
        'statut' => Statut::DejaVendu,
    ]);

    Livewire::test(Editor::class, ['affiche' => $affiche])
        ->assertSet('ville', 'Nantes')
        ->assertSet('statut', 'deja_vendu')
        ->assertSet('afficheId', $affiche->id);
});

it('deletes an affiche from the index', function () {
    $affiche = Affiche::factory()->create();

    Livewire::test(Index::class)
        ->call('delete', $affiche)
        ->assertOk();

    expect(Affiche::find($affiche->id))->toBeNull();
});

it('generates a landscape A4 pdf for an affiche', function () {
    Pdf::fake();

    $affiche = Affiche::factory()->create(['ville' => 'Yerres']);

    get(route('affiches.pdf', $affiche))->assertOk();

    Pdf::assertRespondedWithPdf(fn ($pdf) => $pdf->viewName === 'affiche.pdf'
        && $pdf->orientation === 'Landscape'
        && $pdf->viewData['affiche']->ville === 'Yerres');
});

it('builds the status badge label with a day count', function () {
    expect(Statut::VenduEnJours->label(17))->toBe('VENDU en 17 jours')
        ->and(Statut::VenduEnJours->label(1))->toBe('VENDU en 1 jour')
        ->and(Statut::AVendre->label())->toBe('À VENDRE')
        ->and(Statut::AVendre->afficheIcone())->toBeTrue()
        ->and(Statut::DejaVendu->afficheIcone())->toBeFalse();
});

it('formats the price with thin space separators', function () {
    $affiche = Affiche::factory()->make(['prix' => 419000]);

    expect($affiche->prixFormate())->toBe('419 000 €');
});
