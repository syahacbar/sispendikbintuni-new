<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SysSetting extends Model
{
    // use HasUuids;

    protected $table = 'sys_settings';
    protected $fillable = ['group', 'key', 'value'];

    public static function getAllAsArray(): array
    {
        return static::all()->pluck('value', 'key')->toArray();
    }
}
