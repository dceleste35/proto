<?php

namespace Agicom\Sweepbright\DataObjects\Concerns;

trait HasTranslations
{
    public function locale(?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        $chain = array_unique(array_filter([$locale, config('app.fallback_locale'), 'en']));

        foreach ($chain as $candidate) {
            $value = $this->resolveLocale($candidate);
            if (! is_null($value)) {
                return $value;
            }
        }

        return $this->fr ?? $this->en ?? $this->nl;
    }

    public function __toString(): string
    {
        return $this->locale() ?? '';
    }

    private function resolveLocale(string $locale): ?string
    {
        return match ($locale) {
            'fr' => $this->fr,
            'en' => $this->en,
            'nl' => $this->nl,
            default => null,
        };
    }
}
