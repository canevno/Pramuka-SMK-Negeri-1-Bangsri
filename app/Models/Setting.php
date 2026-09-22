<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public $timestamps = true;

    protected static function ensureTableExists(): bool
    {
        if (! Schema::hasTable('settings')) {
            return false;
        }

        return true;
    }

    public static function getValue(string $key, $default = null): ?string
    {
        if (! static::ensureTableExists()) {
            return $default;
        }

        $value = static::query()->where('key', $key)->value('value');

        return $value !== null ? $value : $default;
    }

    public static function setValue(string $key, $value): self
    {
        if (! static::ensureTableExists()) {
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->longText('value')->nullable();
                $table->timestamps();
            });
        }

        return static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value],
        );
    }
}
