<?php

namespace App\Services\Telemaque;

use Agicom\Telemaque\DTOs\AgencyDTO;
use Agicom\Telemaque\DTOs\UserDTO;
use Agicom\Telemaque\Facades\Telemaque;
use App\Contracts\AdvisorRepository;
use App\Support\Imports\AdvisorData;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Adaptateur Télémaque s'appuyant sur le package agicom/laravel-telemaque.
 * Les conseillers d'une agence arrivent dans AgencyDTO->contacts (Collection<UserDTO>).
 */
class TelemaqueAdvisorRepository implements AdvisorRepository
{
    public function agencyAdvisors(string $agencyCode): Collection
    {
        try {
            $agency = Telemaque::agency()->code($agencyCode);
        } catch (Throwable $e) {
            report($e);

            return collect();
        }

        if (! $agency instanceof AgencyDTO || $agency->contacts === null) {
            return collect();
        }

        return $agency->contacts
            ->filter(fn (UserDTO $user): bool => $user->end_date === null)
            ->map(fn (UserDTO $user): AdvisorData => $this->map($user))
            ->values();
    }

    public function findByEmail(string $email): ?AdvisorData
    {
        try {
            $user = Telemaque::user($email);
        } catch (Throwable $e) {
            report($e);

            return null;
        }

        return $user instanceof UserDTO ? $this->map($user) : null;
    }

    private function map(UserDTO $user): AdvisorData
    {
        $nom = trim(($user->prenom ?? '').' '.($user->nom ?? ''));

        if ($user->contract_type === 'Agent Commercial') {
            $nom .= ' (EI)';
        }

        return new AdvisorData(
            nom: $nom,
            telephone: $this->formatPhone($user->mobile ?: $user->phone),
            photoUrl: $user->photo_path,
            email: $user->email_orpi ?? $user->email ?? '',
        );
    }

    /**
     * Regroupe un numéro français à 10 chiffres en paires ("06 08 04 97 47").
     * Le PhoneCast du package renvoie les chiffres collés.
     */
    private function formatPhone(?string $phone): ?string
    {
        if (blank($phone)) {
            return $phone;
        }

        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        return strlen($digits) === 10 ? implode(' ', str_split($digits, 2)) : $phone;
    }
}
