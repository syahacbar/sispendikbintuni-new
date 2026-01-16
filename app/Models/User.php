<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Filament\Models\Contracts\FilamentUser;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'sys_users';

    // public $incrementing = false;
    // protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sekolah()
    {
        return $this->hasOne(MstSekolah::class, 'users_id', 'id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // ⚠️ PENTING: Email verification dihandle oleh middleware EnsureEmailIsVerified
        // Jangan check hasVerifiedEmail() di sini karena akan return 403 sebelum middleware berfungsi
        // Middleware akan redirect user ke halaman verifikasi jika belum verified
        return $this->hasRole(['super_admin', 'admin_dinas', 'admin_sekolah']);
    }
}
