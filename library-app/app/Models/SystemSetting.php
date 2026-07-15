<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value', 'label', 'group', 'type'])]
class SystemSetting extends Model
{
    /**
     * Get a setting value by key.
     * We deliberately cache only the scalar value (not the Eloquent model)
     * to avoid PHP unserialize errors when the class is not yet autoloaded.
     */
    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $cacheKey = "setting_{$key}";

        // Cache::has returns false on a null value stored, so we use a sentinel.
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting?->value ?? $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function setSetting(string $key, mixed $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting_{$key}");
    }

    /**
     * Get all settings as a keyed collection.
     *
     * @return array<string, mixed>
     */
    public static function getAllSettings(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}
