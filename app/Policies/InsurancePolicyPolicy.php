<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\InsurancePolicy;
use App\Models\User;

class InsurancePolicyPolicy
{
    public function modify(User $user, InsurancePolicy $insurancePolicy):Response
    {
        return $user->id === $insurancePolicy->user_id
        ? Response::allow()
        : Response::deny('You do not have authorization');
    }
}
