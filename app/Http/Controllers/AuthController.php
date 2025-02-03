<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'succes' => false,
                'message' => 'Failed to create the account, please check your input data',
                'data' => null,
                'errors' => $validator->errors()
            ];
            return response()->json($response,400);
        }

        $user = User::create($validator->validated());
        $response = [
            'succes' => true,
            'message' => 'Successfully created your account',
            'data' => $user
        ];
    return response()->json($response,201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Failed to Login',
                'data' => null,
                'errors' => $validator->errors()
            ];
            return response()->json($response,400);
        }

        $credential = $request->only('email','password');

        if(!$token = auth()->guard('api')->attempt($credential)){
            $response = [
                'success' => false,
                'message' => 'Wrong username or password',
                'data' => null
            ];
            return response()->json($response,400);
        }

        $response = [
            'success' => true,
            'message' => 'Succesfully Login',
            'data' => auth()->guard('api')->user(),
            'accestoken' => $token
        ];
        return response()->json($response,201);
    }
}
