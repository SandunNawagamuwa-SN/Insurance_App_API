<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsurancePolicy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'policy_number',
        'holder_name',
        'type_of_insurance',
        'coverage_amount'
    ];
}
