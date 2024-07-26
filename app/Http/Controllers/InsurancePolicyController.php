<?php

namespace App\Http\Controllers;

use App\Models\InsurancePolicy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class InsurancePolicyController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InsurancePolicy::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'policy_number' => 'required|max:255',
            'holder_name' => 'required|max:255',
            'type_of_insurance' => 'required|max:255',
            'coverage_amount' => 'required|max:255',
        ]);

        $insurancePolicy = $request->user()->insurancePolicies()->create($fields);

        return $insurancePolicy;
    }

    /**
     * Display the specified resource.
     */
    public function show(InsurancePolicy $insurancePolicy)
    {
        return $insurancePolicy;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InsurancePolicy $insurancePolicy)
    {
        Gate::authorize('modify', $insurancePolicy);
        
        $fields = $request->validate([
            'policy_number' => 'required|max:255',
            'holder_name' => 'required|max:255',
            'type_of_insurance' => 'required|max:255',
            'coverage_amount' => 'required|max:255',
        ]);

        $insurancePolicy->update($fields);

        return $insurancePolicy;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InsurancePolicy $insurancePolicy)
    {
        Gate::authorize('modify', $insurancePolicy);

        $insurancePolicy->delete();

        return ['message' => 'The policy was deleted'];
    }
}
