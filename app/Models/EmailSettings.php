<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\EmailSettingsObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([EmailSettingsObserver::class])]

class EmailSettings extends Model
{
    protected $table = 'email_settings';
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        // Handle boolean values
        if ($setting->value === 'true') return true;
        if ($setting->value === 'false') return false;

        return $setting->value;
    }

    public static function setValue(string $key, mixed $value): void
    {
        // Convert boolean to string for storage
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        // Handle numeric status values
        if ($key === 'status' && ($value === 1 || $value === '1')) {
            $value = 'true';
        } elseif ($key === 'status' && ($value === 0 || $value === '0')) {
            $value = 'false';
        }

        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAllAsArray(): array
    {
        $settings = static::all();
        $result = [];

        foreach ($settings as $setting) {
            // Convert string booleans to actual booleans
            if ($setting->value === 'true' || $setting->value === '1') {
                $result[$setting->key] = true;
            } elseif ($setting->value === 'false' || $setting->value === '0') {
                $result[$setting->key] = false;
            } else {
                $result[$setting->key] = $setting->value;
            }
        }

        return $result;
    }

    public static function setBulk(array $data): void
    {
        foreach ($data as $key => $value) {
            static::setValue($key, $value);
        }
    }
}
