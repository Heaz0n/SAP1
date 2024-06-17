<?php

namespace App\DTOs;

class AuthDTO
{
    public $accessToken;
    public $tokenType;
    public $expiresAt;

    public function __construct($accessToken, $tokenType, $expiresAt)
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresAt = $expiresAt;
    }

    public function toArray()
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => $this->tokenType,
            'expires_at' => $this->expiresAt,
        ];
    }
}
