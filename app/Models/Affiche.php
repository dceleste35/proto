<?php

namespace App\Models;

use App\Enums\QrPosition;
use App\Enums\Statut;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Database\Factories\AfficheFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $ville
 * @property string $type_bien
 * @property string|null $pieces
 * @property int|null $surface
 * @property int|null $prix
 * @property string $dpe_classe
 * @property int|null $dpe_valeur
 * @property string $ges_classe
 * @property int|null $ges_valeur
 * @property string|null $accroche
 * @property string|null $description
 * @property string|null $mentions_legales
 * @property Statut $statut
 * @property int|null $statut_jours
 * @property QrPosition $qr_position
 * @property string|null $qr_url
 * @property bool $agent_visible
 * @property string|null $agent_nom
 * @property string|null $agent_telephone
 * @property string|null $agent_photo_path
 * @property string|null $photo_path
 */
class Affiche extends Model
{
    /** @use HasFactory<AfficheFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'statut' => Statut::class,
            'qr_position' => QrPosition::class,
            'agent_visible' => 'boolean',
            'surface' => 'integer',
            'prix' => 'integer',
            'dpe_valeur' => 'integer',
            'ges_valeur' => 'integer',
            'statut_jours' => 'integer',
        ];
    }

    /**
     * Libellé du badge, jours interpolés si nécessaire.
     */
    public function badgeLabel(): string
    {
        return $this->statut->label($this->statut_jours);
    }

    /**
     * Prix formaté « 419 000 € » (espace fine insécable comme séparateur).
     */
    public function prixFormate(): ?string
    {
        if ($this->prix === null) {
            return null;
        }

        return number_format($this->prix, 0, ',', ' ').' €';
    }

    /**
     * URL publique de la photo principale (ou placeholder).
     */
    public function photoUrl(): ?string
    {
        return $this->resolveImageUrl($this->photo_path);
    }

    public function agentPhotoUrl(): ?string
    {
        return $this->resolveImageUrl($this->agent_photo_path);
    }

    /**
     * Résout une image : URL absolue (import SweepBright/Télémaque/fixtures) telle quelle,
     * sinon chemin relatif sur le disque public (upload).
     */
    private function resolveImageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        return str($path)->startsWith(['http://', 'https://'])
            ? $path
            : Storage::disk('public')->url($path);
    }

    /**
     * Couleur d'accent (badge, QR, encadré conseiller) = couleur du statut.
     */
    public function accentColor(): string
    {
        return $this->statut->couleur();
    }

    /**
     * @return array{0: int, 1: int, 2: int} composantes RGB de la couleur d'accent
     */
    private function accentRgb(): array
    {
        $hex = ltrim($this->accentColor(), '#');

        return [
            (int) hexdec(substr($hex, 0, 2)),
            (int) hexdec(substr($hex, 2, 2)),
            (int) hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * QR code (SVG en data-URI) prêt à embarquer dans un <img>, ou null si désactivé.
     */
    public function qrDataUri(int $size = 320): ?string
    {
        // Le QR est généré dès qu'une URL est présente ; son emplacement (ou son
        // affichage) est décidé par la vue, ce qui permet de le forcer quand le
        // conseiller est masqué.
        if (blank($this->qr_url)) {
            return null;
        }

        [$r, $g, $b] = $this->accentRgb();

        $style = new RendererStyle(
            size: $size,
            margin: 0,
            fill: Fill::uniformColor(new Rgb(255, 255, 255), new Rgb($r, $g, $b)),
        );
        $writer = new Writer(new ImageRenderer($style, new SvgImageBackEnd));

        $svg = $writer->writeString($this->qr_url);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
