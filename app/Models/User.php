<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'birthday',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime',
    ];

    /**
     * Generate a new two-factor authentication code and set its expiration time.
     *
     * @return void
     */
    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = Carbon::now()->addMinutes(config('auth.two_factor_expiration'));
        $this->save(); // Сохраняем изменения в базе данных
    }

    /**
     * Check if the two-factor authentication code has expired.
     *
     * @return bool
     */
    public function twoFactorCodeExpired()
    {
        return $this->two_factor_expires_at->lt(Carbon::now());
    }

    /**
     * Validate the two-factor authentication code provided by the user.
     *
     * @param string $code
     * @return bool
     */
    public function validateTwoFactorCode($code)
    {
        return $this->two_factor_code === $code;
    }

    /**
     * Clear the two-factor authentication code and its expiration time.
     *
     * @return void
     */
    public function clearTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save(); // Сохраняем изменения в базе данных
    }
}