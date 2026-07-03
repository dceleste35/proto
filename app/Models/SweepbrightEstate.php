<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RuntimeException;

/**
 * Modèle EN LECTURE SEULE sur la base SweepBright partagée, alimentée par
 * l'application agiprint (même approche que qr-switch). La table est configurée
 * via services.sweepbright.table (env SWEEPBRIGHT_TABLE).
 *
 * @property int $id
 * @property string $estate_id
 * @property string|null $office_id
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $type
 * @property string|null $market_status
 * @property string|null $price
 * @property string|null $reference
 * @property string|null $email
 * @property array<string, mixed>|null $data
 * @property array<string, mixed>|null $title
 * @property array<string, mixed>|null $description
 */
class SweepbrightEstate extends Model
{
    use SoftDeletes;

    protected $connection = 'agiprint';

    /** @var list<string> */
    protected $guarded = ['*'];

    public function getTable(): string
    {
        return (string) config('services.sweepbright.table', 'estates');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'title' => 'array',
            'description' => 'array',
            'is_project' => 'boolean',
        ];
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function save(array $options = []): never
    {
        throw new RuntimeException('SweepbrightEstate est en lecture seule.');
    }

    public function delete(): never
    {
        throw new RuntimeException('SweepbrightEstate est en lecture seule.');
    }
}
