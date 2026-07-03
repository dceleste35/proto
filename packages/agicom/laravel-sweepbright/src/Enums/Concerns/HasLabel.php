<?php

namespace Agicom\Sweepbright\Enums\Concerns;

use Illuminate\Support\Str;

trait HasLabel
{
    public function getLabel(?string $locale = null): string
    {
        $group = Str::of(class_basename(static::class))->snake()->toString();
        $key = "sweepbright::{$group}.{$this->value}";
        $translated = trans($key, [], $locale ?? app()->getLocale());

        if ($translated === $key) {
            return Str::of($this->value)->replace('_', ' ')->ucfirst()->toString();
        }

        return $translated;
    }
}
