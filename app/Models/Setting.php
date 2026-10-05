<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Auditable, HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
    ];

    /**
     * Mengambil nilai setting berdasarkan key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        try {
            $setting = static::where('key', $key)->first();

            if ($setting === null) {
                return $default;
            }

            $value = $setting->value;

            // Cek jika format JSON
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) {
                return $decoded;
            }

            return $value;
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * Menyimpan atau memperbarui nilai setting.
     */
    public static function set(string $key, mixed $value, string $group = 'general', ?string $description = null): self
    {
        $storedValue = is_array($value) || is_object($value) ? json_encode($value) : (string) $value;

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $storedValue,
                'group' => $group,
                'description' => $description,
            ]
        );
    }
}
