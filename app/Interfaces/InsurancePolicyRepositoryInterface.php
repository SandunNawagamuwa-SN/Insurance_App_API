<?php

namespace App\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface InsurancePolicyRepositoryInterface
{
    public function index();
    public function getById($id);
    public function store(array $data, Authenticatable $user);
    public function update(array $data, $id);
    public function delete($id);
}
