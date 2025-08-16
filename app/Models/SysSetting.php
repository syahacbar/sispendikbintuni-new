<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysSetting extends Model
{
    protected $table = 'sys_settings';
    protected $fillable = ['group', 'key', 'value'];

    public static function getAllAsArray(): array
    {
        return static::all()
            ->pluck('value', 'key')
            ->map(function ($value) {
                $decoded = json_decode($value, true);

                return (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
                    ? $decoded
                    : $value;
            })
            ->toArray();
    }

    public static function setBulk(array $data): void
    {
        foreach ($data as $key => $value) {
            static::setValue($key, $value);
        }
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
