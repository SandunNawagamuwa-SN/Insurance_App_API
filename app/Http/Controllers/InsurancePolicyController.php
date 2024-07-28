<?php

namespace App\Http\Controllers;

use App\Models\InsurancePolicy;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Resources\InsurancePolicyResource;
use App\Http\Requests\StoreInsurancePolicyRequest;
use App\Http\Requests\UpdateInsurancePolicyRequest;
use App\Interfaces\InsurancePolicyRepositoryInterface;
use App\Http\Resources\InsurancePolicyCollectionResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class InsurancePolicyController extends Controller implements HasMiddleware
{

    private InsurancePolicyRepositoryInterface $insurancePolicyRepositoryInterface;
    
    public function __construct(InsurancePolicyRepositoryInterface $insurancePolicyRepositoryInterface)
    {
        $this->insurancePolicyRepositoryInterface = $insurancePolicyRepositoryInterface;
    }

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
        // return InsurancePolicy::all();
        $data = $this->insurancePolicyRepositoryInterface->index();
        // return $data;
        return ApiResponseClass::sendResponse(new InsurancePolicyCollectionResource($data),null,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsurancePolicyRequest $request)
    {
        $user = $request->user();

        $details = [
            'policy_number' => $request->policy_number,
            'holder_name' => $request->holder_name,
            'type_of_insurance' => $request->type_of_insurance,
            'coverage_amount' => $request->coverage_amount,
        ];

        DB::beginTransaction();

        try{
            $insurancePolicy = $this->insurancePolicyRepositoryInterface->store($details, $user);

            // $insurancePolicy = $request->user()->insurancePolicies()->create($fields);

            DB::commit();
            return ApiResponseClass::sendResponse(new InsurancePolicyResource($insurancePolicy),'Inusrance Policy Create Successful',201);

       }catch(\Exception $ex){
           return ApiResponseClass::rollback($ex);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $insurancePolicy = $this->insurancePolicyRepositoryInterface->getById($id);
    
        return ApiResponseClass::sendResponse(new InsurancePolicyResource($insurancePolicy),null,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInsurancePolicyRequest $request, $id)
    {
        Gate::authorize('modify', $this->insurancePolicyRepositoryInterface->getById($id));

        $updateDetails = [
            'policy_number' => $request->policy_number,
            'holder_name' => $request->holder_name,
            'type_of_insurance' => $request->type_of_insurance,
            'coverage_amount' => $request->coverage_amount,
        ];

        DB::beginTransaction();

        try{
            $insurancePolicy = $this->insurancePolicyRepositoryInterface->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse(new InsurancePolicyResource($insurancePolicy),'Insurance Policy Update Successful',200);

       }catch(\Exception $ex){
           return ApiResponseClass::rollback($ex);
       }
        
        // $fields = $request->validate([
        //     'policy_number' => 'required|max:255',
        //     'holder_name' => 'required|max:255',
        //     'type_of_insurance' => 'required|max:255',
        //     'coverage_amount' => 'required|max:255',
        // ]);

        // $insurancePolicy->update($fields);

        // return $insurancePolicy;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InsurancePolicy $insurancePolicy)
    {
        Gate::authorize('modify', $insurancePolicy);

        $this->insurancePolicyRepositoryInterface->delete($insurancePolicy->id);

        return ApiResponseClass::sendResponse(null,'Insurance Policy Delete Successfully',204);
    }
}
