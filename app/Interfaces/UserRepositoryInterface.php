<?php

namespace App\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepositoryInterface
{
    public function store(array $data);
    public function deleteTokens(Authenticatable $user);
}
