<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SchoolInvitationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'npsn',
        'email',
        'expires_at',
        'used_at',
        'used_by_user_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Relasi ke sekolah
     */
    public function sekolah()
    {
        return $this->belongsTo(MstSekolah::class, 'npsn', 'npsn');
    }

    /**
     * Relasi ke user yang membuat token
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * Relasi ke user yang menggunakan token
     */
    public function consumer()
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }

    /**
     * Check apakah token masih valid
     */
    public function isValid(): bool
    {
        return $this->used_at === null
            && $this->expires_at > now();
    }

    /**
     * Check apakah email cocok dengan token
     * Jika token tidak spesifik ke email, return true
     */
    public function isEmailMatch(?string $email): bool
    {
        if ($this->email === null) {
            return true; // Token dapat digunakan oleh siapa saja
        }

        return strtolower($this->email) === strtolower($email);
    }

    /**
     * Mark token sebagai sudah digunakan
     */
    public function markAsUsed(int $userId): void
    {
        $this->update([
            'used_at' => now(),
            'used_by_user_id' => $userId,
        ]);
    }

    /**
     * Generate token unik
     */
    public static function generateUniqueToken(int $length = 16): string
    {
        do {
            $token = strtoupper(Str::random($length));
        } while (self::where('token', $token)->exists());

        return $token;
    }

    /**
     * Scope untuk token yang masih aktif
     */
    public function scopeActive($query)
    {
        return $query->whereNull('used_at')
            ->where('expires_at', '>', now());
    }

    /**
     * Scope untuk token yang sudah digunakan
     */
    public function scopeUsed($query)
    {
        return $query->whereNotNull('used_at');
    }

    /**
     * Scope untuk token yang expired
     */
    public function scopeExpired($query)
    {
        return $query->whereNull('used_at')
            ->where('expires_at', '<=', now());
    }

    /**
     * Accessor untuk status token
     */
    public function getStatusAttribute(): string
    {
        if ($this->used_at !== null) {
            return 'Sudah Digunakan';
        }

        if ($this->expires_at <= now()) {
            return 'Kadaluarsa';
        }

        return 'Aktif';
    }

    /**
     * Accessor untuk badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Aktif' => 'success',
            'Sudah Digunakan' => 'gray',
            'Kadaluarsa' => 'danger',
            default => 'gray',
        };
    }
}
