<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\PatientLoginRequest;
use App\Http\Requests\Api\Auth\PatientRegisterRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(PatientRegisterRequest $request){
        try{
            $patient = Patient::create($request->parseData());

            return response()->json([
                'patient' => $patient->only([
                    'id', 
                    'name',
                    'email'
                ]),
                'token' => $patient->createToken('patient', ['patient'])->plainTextToken
            ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(PatientLoginRequest $request){
        try{
            $patient = Patient::whereEmail($request->email)->first();

            if(!$patient->exists() || !Hash::check($request->password, $patient->password)){
                return response()->json([
                    'message' => 'Login failure, due to incorrect email or password',
                    'errors' => [
                        'email' => [
                            'your credentials are incorrect, try again'
                        ]
                    ]
                ]);
            }
            // revoke the old tokens
            $patient->tokens()->delete();

            return response()->json([
                'patient' => $patient->only([
                    'id',   
                    'name',
                    'email',
                    'phone',
                    'gender'
                ]),
                'token' => $patient->createToken('patient', ['patient'])->plainTextToken
            ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
