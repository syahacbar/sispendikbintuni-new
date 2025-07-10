<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tentang extends Model
{
    protected $table = 'tbl_tentangs';

    protected $fillable = ['id', 'key', 'value', 'sort_order'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public static function getAllAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function setBulk(array $data): void
    {
        foreach ($data as $key => $value) {
            static::setValue($key, $value);
        }
    }
}
