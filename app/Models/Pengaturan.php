<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasUuids;

    protected $table = 'tbl_pengaturans';
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAllAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    public static function setBulk(array $data): void
    {
        foreach ($data as $key => $value) {
            static::setValue($key, $value);
        }
    }
}
