<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{

    private UserRepositoryInterface $userRepositoryInterface;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    // public function register(Request $request)
    // {
    //     $fields = $request->validate([
    //         'name' => 'required|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|confirmed'
    //     ]);

    //     $user = User::create($fields);

    //     $token = $user->createToken($request->name);

    //     return [
    //         'user' => $user,
    //         'token' => $token->plainTextToken
    //     ];
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users',
    //         'password' => 'required'
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if(!$user || !Hash::check($request->password, $user->password)){
    //         // return [
    //         //     'message' => 'The provided credentials are incorrect' 
    //         // ];
    //         throw new HttpResponseException(response()->json([
    //             'success'   => false,
    //             'message'   => 'Validation errors',
    //             'data'      => []
    //         ], 201));
    //         // throw new HttpResponseException(Response::json([
    //         //     'success'   => false,
    //         //     'message'   => 'Validation errors',
    //         //     'data'      => []
    //         // ], 201));
    //         // Response::json([
    //         //     'hello' => $value
    //         // ], 201);
    //     }

    //     $token = $user->createToken($user->name);

    //     return [
    //         'user' => $user,
    //         'token' => $token->plainTextToken
    //     ];
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();

    //     return [
    //         'message' => 'You are logged out'
    //     ];
    // }


    public function login(LoginRequest $request)
    {
        // $data = $request->validated();

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if(!Auth::attempt($data)){
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Invalid Credentials',
            ], 401));
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return ApiResponseClass::sendResponse(['user' => $user->name, 'email' => $user->email, 'token' => $token], null, 200);

        // return response()->json([
        //     'user' => $user,
        //     'token' => $token
        // ]);

    }

    public function register(RegisterRequest $request)
    {

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);

        DB::beginTransaction();

        try{
            $user= $this->userRepositoryInterface->store([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('main')->plainTextToken;

            // $insurancePolicy = $request->user()->insurancePolicies()->create($fields);

            DB::commit();
            return ApiResponseClass::sendResponse(['user' => $user->name, 'email' => $user->email, 'token' => $token], 'Successfully Registered', 200);

       }catch(\Exception $ex){
           return ApiResponseClass::rollback($ex);
       }

        // $token = $user->createToken('main')->plainTextToken;

        // return ApiResponseClass::sendResponse(['user' => $user->name, 'email' => $user->email, 'token' => $token], 'Successfully Registered', 200);

        // return response()->json([
        //     'user' => $user,
        //     'token' => $token
        // ]);
    }

    public function logout(Request $request)
    {
        $this->userRepositoryInterface->deleteTokens($request->user());

        return ApiResponseClass::sendResponse(null, null, 204);
    }
}
