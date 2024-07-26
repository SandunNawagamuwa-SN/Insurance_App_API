<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InsurancePolicyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'policy_number' => $this->policy_number, 
            'holder_name' => $this->holder_name,
            'type_of_insurance' => $this->type_of_insurance,
            'coverage_amount' => $this->coverage_amount
        ];
    }
}
