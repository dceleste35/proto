<?php

namespace App\Livewire\Affiches;

use App\Contracts\AdvisorRepository;
use App\Contracts\PropertyRepository;
use App\Enums\QrPosition;
use App\Enums\Statut;
use App\Models\Affiche;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Éditeur d\'affiche')]
class Editor extends Component
{
    public ?int $afficheId = null;

    // Bien
    public string $ville = '';

    public string $type_bien = 'Maison';

    public string $pieces = '';

    public ?int $surface = null;

    public ?int $prix = null;

    // Diagnostics
    public string $dpe_classe = 'C';

    public ?int $dpe_valeur = null;

    public string $ges_classe = 'C';

    public ?int $ges_valeur = null;

    // Contenu
    public string $accroche = '';

    public string $description = '';

    public string $mentions_legales = "Honoraires charge vendeur. Montant estimé des dépenses annuelles d'énergie pour un usage standard.";

    // Statut
    public string $statut = 'a_vendre';

    public ?int $statut_jours = 17;

    // QR
    public string $qr_position = 'haut_droite';

    public string $qr_url = 'https://www.orpi.com';

    // Agent
    public bool $agent_visible = true;

    public string $agent_nom = '';

    public string $agent_telephone = '';

    public ?string $agent_photo_path = null;

    // Média (URL choisie parmi les photos du bien dans le bucket)
    public ?string $photo_path = null;

    /** @var array<int, string> photos disponibles du bien sélectionné (bucket) */
    public array $estatePhotos = [];

    // Sélection agence (démo : Agence Anglard, code 050199)
    public string $agencyCode = '050199';

    public string $officeId = '038f49be-8b42-484e-8291-a2635a090d1f';

    public ?string $selectedEstateId = null;

    public ?string $selectedAdvisorEmail = null;

    /** @var array<int, array{id: string, ville: string, type: string, prix: int|null, reference: string|null, statut: string, thumb: string|null}> */
    public array $estates = [];

    /** @var array<int, array{email: string, nom: string, tel: string|null, photo: string|null}> */
    public array $advisors = [];

    public function mount(PropertyRepository $properties, AdvisorRepository $advisors, ?Affiche $affiche = null): void
    {
        if ($affiche && $affiche->exists) {
            $this->afficheId = $affiche->id;
            $this->fill($affiche->only([
                'ville', 'type_bien', 'pieces', 'surface', 'prix',
                'dpe_classe', 'dpe_valeur', 'ges_classe', 'ges_valeur',
                'accroche', 'description', 'mentions_legales',
                'statut_jours', 'qr_url', 'agent_visible',
                'agent_nom', 'agent_telephone', 'agent_photo_path', 'photo_path',
            ]));
            $this->statut = $affiche->statut->value;
            $this->qr_position = $affiche->qr_position->value;
        }

        // Charge les biens et conseillers de l'agence (une seule fois, au montage).
        $this->estates = $properties->estatesForOffice($this->officeId)
            ->map(fn ($e): array => [
                'id' => $e->id, 'ville' => $e->ville, 'type' => $e->typeBien,
                'prix' => $e->prix, 'reference' => $e->reference, 'statut' => $e->statut, 'thumb' => $e->thumbnailUrl,
            ])->all();

        $this->advisors = $advisors->agencyAdvisors($this->agencyCode)
            ->map(fn ($a): array => [
                'email' => $a->email, 'nom' => $a->nom, 'tel' => $a->telephone, 'photo' => $a->photoUrl,
            ])->all();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'ville' => ['required', 'string', 'max:60'],
            'type_bien' => ['required', 'string', 'max:40'],
            'pieces' => ['nullable', 'string', 'max:40'],
            'surface' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'prix' => ['nullable', 'integer', 'min:0'],
            'dpe_classe' => ['required', 'in:A,B,C,D,E,F,G'],
            'dpe_valeur' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'ges_classe' => ['required', 'in:A,B,C,D,E,F,G'],
            'ges_valeur' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'accroche' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:5000'],
            'mentions_legales' => ['nullable', 'string', 'max:500'],
            'statut' => ['required', 'in:'.implode(',', array_column(Statut::cases(), 'value'))],
            'statut_jours' => ['nullable', 'integer', 'min:0', 'max:999'],
            'qr_position' => ['required', 'in:'.implode(',', array_column(QrPosition::cases(), 'value'))],
            'qr_url' => ['nullable', 'url', 'max:255'],
            'agent_visible' => ['boolean'],
            'agent_nom' => ['nullable', 'string', 'max:60'],
            'agent_telephone' => ['nullable', 'string', 'max:30'],
        ];
    }

    /**
     * Choisit la photo à afficher parmi celles du bien (bucket).
     */
    public function selectPhoto(string $url): void
    {
        if (in_array($url, $this->estatePhotos, true)) {
            $this->photo_path = $url;
        }
    }

    /**
     * Sélectionne un bien de l'agence : le bien et ses diagnostics viennent de
     * SweepBright (source de vérité) et remplissent l'affiche.
     */
    public function selectEstate(string $estateId, PropertyRepository $properties): void
    {
        $data = $properties->find($estateId);

        if ($data === null) {
            return;
        }

        $this->selectedEstateId = $estateId;

        $this->ville = $data->ville;
        $this->type_bien = $data->typeBien;
        $this->pieces = $data->pieces;
        $this->surface = $data->surface;
        $this->prix = $data->prix;
        if ($data->dpeClasse !== null) {
            $this->dpe_classe = $data->dpeClasse;
        }
        $this->dpe_valeur = $data->dpeValeur;
        if ($data->gesClasse !== null) {
            $this->ges_classe = $data->gesClasse;
        }
        $this->ges_valeur = $data->gesValeur;
        $this->accroche = $data->accroche;
        $this->description = $data->description;
        $this->statut = $data->statut;

        // Photos du bucket : on propose le choix, la 1re est sélectionnée par défaut.
        $this->estatePhotos = $data->photos !== [] ? $data->photos : array_filter([$data->photoUrl]);
        $this->photo_path = $this->estatePhotos[0] ?? null;

        // Le QR pointe toujours vers le lien du bien (non modifiable par l'utilisateur).
        if ($data->propertyUrl !== null) {
            $this->qr_url = $data->propertyUrl;
        }

        session()->flash('imported', 'Bien « '.$data->ville.' » sélectionné depuis SweepBright.');
    }

    /**
     * Sélectionne un conseiller de l'agence (données Télémaque déjà chargées).
     */
    public function selectAdvisor(string $email): void
    {
        $advisor = collect($this->advisors)->firstWhere('email', $email);

        if ($advisor === null) {
            return;
        }

        $this->selectedAdvisorEmail = $email;
        $this->agent_visible = true;
        $this->agent_nom = $advisor['nom'];
        $this->agent_telephone = $advisor['tel'] ?? '';
        if (filled($advisor['photo'])) {
            $this->agent_photo_path = $advisor['photo'];
        }
    }

    public function save(): void
    {
        $data = $this->validate();

        $affiche = Affiche::updateOrCreate(
            ['id' => $this->afficheId],
            [...$data, 'photo_path' => $this->photo_path, 'agent_photo_path' => $this->agent_photo_path],
        );

        $this->afficheId = $affiche->id;

        session()->flash('saved', 'Affiche enregistrée.');
        $this->redirectRoute('affiches.edit', $affiche, navigate: true);
    }

    /**
     * Construit une instance non persistée à partir de l'état courant, pour l'aperçu live.
     */
    public function preview(): Affiche
    {
        return new Affiche([
            'ville' => $this->ville ?: 'Ville',
            'type_bien' => $this->type_bien,
            'pieces' => $this->pieces,
            'surface' => $this->surface,
            'prix' => $this->prix,
            'dpe_classe' => $this->dpe_classe,
            'dpe_valeur' => $this->dpe_valeur,
            'ges_classe' => $this->ges_classe,
            'ges_valeur' => $this->ges_valeur,
            'accroche' => $this->accroche,
            'description' => $this->description,
            'mentions_legales' => $this->mentions_legales,
            'statut' => $this->statut,
            'statut_jours' => $this->statut_jours,
            'qr_position' => $this->qr_position,
            'qr_url' => $this->qr_url,
            'agent_visible' => $this->agent_visible,
            'agent_nom' => $this->agent_nom,
            'agent_telephone' => $this->agent_telephone,
            'agent_photo_path' => $this->agent_photo_path,
            'photo_path' => $this->photo_path,
        ]);
    }

    public function render(): View
    {
        return view('livewire.affiches.editor', [
            'preview' => $this->preview(),
            'statuts' => Statut::options(),
            'qrPositions' => QrPosition::options(),
            'classes' => ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
            'statutRequiertJours' => Statut::from($this->statut)->requiertJours(),
        ]);
    }
}
