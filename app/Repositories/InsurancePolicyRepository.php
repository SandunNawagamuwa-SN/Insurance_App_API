<?php

namespace App\Repositories;

use App\Models\InsurancePolicy;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Interfaces\InsurancePolicyRepositoryInterface;

class InsurancePolicyRepository implements InsurancePolicyRepositoryInterface
{
    public function index(){
        return InsurancePolicy::paginate(5);
    }

    public function getById($id){
        return InsurancePolicy::findOrFail($id);
    }

    public function store(array $data, Authenticatable $user){
        return $user->insurancePolicies()->create($data);
    }

    public function update(array $data, $id){
        $policy = InsurancePolicy::findOrFail($id);
        $policy->update($data);
        return $policy;
    }

    public function delete($id){
        InsurancePolicy::destroy($id);
    }
}
