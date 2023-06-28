<?php

namespace App\Models;

use Laravel\Sanctum\Sanctum;
// use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\PersonalAccessToken as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class PersonalAccessToken extends Model
{
    // protected $table = 'personal_access_tokens';

    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expired_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expired_at'
    ];

    // protected function isValidAccessToken($accessToken): bool
    // {
    //     if (! $accessToken) {
    //         return false;
    //     }

    //     $isValid =
    //         (! $this->expiration || $accessToken->created_at->gt(now()->subMinutes($this->expiration)))
    //         && $this->hasValidProvider($accessToken->tokenable);

    //     if (is_callable(Sanctum::$accessTokenAuthenticationCallback)) {
    //         $isValid = (bool) (Sanctum::$accessTokenAuthenticationCallback)($accessToken, $isValid);
    //     }

    //     return $isValid;
    // }
}