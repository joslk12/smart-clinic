<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model): void {
            $source = $model->slugSource();

            if (blank($model->slug) && filled($model->{$source})) {
                $model->slug = static::generateUniqueSlug((string) $model->{$source}, $model);
            }
        });
    }

    protected function slugSource(): string
    {
        return 'title';
    }

    protected static function generateUniqueSlug(string $value, ?Model $model = null): string
    {
        $base = Str::slug($value) ?: Str::lower(Str::random(8));
        $slug = $base;
        $suffix = 1;

        while (static::slugExists($slug, $model)) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    protected static function slugExists(string $slug, ?Model $model = null): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($model?->exists, fn ($query) => $query->whereKeyNot($model->getKey()))
            ->exists();
    }
}
