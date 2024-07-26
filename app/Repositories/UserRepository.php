<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data){
        return User::create($data);
    }

    public function deleteTokens(Authenticatable $user){
        return $user->currentAccessToken()->delete();
    }
}
