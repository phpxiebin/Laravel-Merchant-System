<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class MerchantEloquentUserProvider extends EloquentUserProvider
{
    /**
     * 重写密码验证
     * @param Authenticatable $user
     * @param array $credentials
     * @return mixed
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];
        $authPassword = $user->getAuthPassword();
        return Hash::check($plain . $authPassword['salt'], $authPassword['password']);
    }
}
