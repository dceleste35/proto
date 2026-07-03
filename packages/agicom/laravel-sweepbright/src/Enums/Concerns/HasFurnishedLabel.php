<?php

namespace Agicom\Sweepbright\Enums\Concerns;

use Illuminate\Support\Str;

trait HasFurnishedLabel
{
    public function getFurnishedLabel(?string $locale = null): string
    {
        $group = Str::of(class_basename(static::class))->snake()->toString();
        $key = "sweepbright::{$group}.furnished.{$this->value}";
        $translated = trans($key, [], $locale ?? app()->getLocale());

        if ($translated === $key) {
            return 'Furnished '.$this->getLabel($locale);
        }

        return $translated;
    }
}
