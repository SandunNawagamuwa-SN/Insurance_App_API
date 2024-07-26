<?php

namespace App\Repositories;

use App\Models\InsurancePolicy;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Interfaces\InsurancePolicyRepositoryInterface;

class InsurancePolicyRepository implements InsurancePolicyRepositoryInterface
{
    public function index(){
        return InsurancePolicy::all();
    }

    public function getById($id){
        return InsurancePolicy::findOrFail($id);
    }

    public function store(array $data, Authenticatable $user){
        return $user->insurancePolicies()->create($data);
    }

    public function update(array $data, $id){
        return InsurancePolicy::whereId($id)->update($data);
    }

    public function delete($id){
        InsurancePolicy::destroy($id);
    }
}
