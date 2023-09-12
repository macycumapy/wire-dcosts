<?php

declare(strict_types=1);

namespace App\Enums\Traits;

use Illuminate\Support\Collection;

trait WithTitles
{
    use WithValues;

    public function title(): string
    {
        return '';
    }

    public static function titles(): array
    {
        return collect(self::cases())
            ->filter(fn (self $item) => !$item->isHidden())
            ->map(fn (self $item) => $item->title())
            ->toArray();
    }

    public function valueWithTitle(): array
    {
        return [
            'value' => $this->value,
            'title' => $this->title()
        ];
    }

    public static function valuesWithTitles(): Collection
    {
        return collect(self::cases())
            ->filter(fn (self $item) => !$item->isHidden())
            ->map(fn (self $item) => $item->valueWithTitle());
    }

    public static function namesWithTitles(): Collection
    {
        return collect(self::cases())
            ->filter(fn (self $item) => !$item->isHidden())
            ->map(fn ($item) => [
                'name' => $item->name,
                'title' => $item->title()
            ]);
    }

    public static function titledValues(): Collection
    {
        return collect(self::cases())
            ->filter(fn (self $item) => !$item->isHidden())
            ->mapWithKeys(fn (self $item) => [
                $item->title() => $item->value,
            ]);
    }

    public static function fromTitle(?string $title): ?static
    {
        $found = self::valuesWithTitles()->where('title', $title)->first();
        if (!$found) {
            return null;
        }

        return self::tryFrom($found['value']);
    }

    public function isHidden(): bool
    {
        return false;
    }
}
