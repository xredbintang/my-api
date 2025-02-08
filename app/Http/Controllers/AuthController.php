<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        if(!$token = JWTAuth::attempt($credential)){
            $response = [
                'success' => false,
                'message' => 'Wrong username or password',
                'data' => null
            ];
            return response()->json($response,400);
        }

        $refreshtoken = JWTAuth::fromUser(auth()->user());
        $response = [
            'success' => true,
            'message' => 'Succesfully Login',
            'data' => auth()->guard('api')->user(),
            'accestoken' => $token,
            'refresh_token' => $refreshtoken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60 
        ];
        return response()->json($response,200);
        // return redirect()->route('dashboard')->with('token',$token);
    }
    public function logout(Request $request)
{
    try {
        auth('api')->logout();
        auth('api')->invalidate(true);        
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out',
            'data' => null
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to logout',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function refreshToken() {
    try {
        
        $newtoken = JWTAuth::parseToken()->refresh();
        $response = [
            'success' => true,
            'message' => 'Token refreshed successfully',
            'data' => null,
            'access_token' => $newtoken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60, 
        ];
        return response()->json($response, 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to refresh token',
            'error' => $e->getMessage()
        ], 401);
    }
}


    public function dashboard(){
        
        return view('welcome');
    }
}
