<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'abilities',
        'name',
        'last_used_at',
        'expires_at',
        'revoked',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked' => 'boolean',
    ];

    /**
     * Determine if the token is revoked.
     *
     * @return bool
     */
    public function isRevoked()
    {
        return (bool) $this->revoked;
    }
}
