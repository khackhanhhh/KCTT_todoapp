<?php

namespace App\Http\Controllers\Api\v1;

use Config;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()->all()],405);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully created user!',
            'token' => $user->createToken('token')->accessToken,
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()->all()],400);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = $request->user();
            return response()->json([
                'response' => 'success',
                'result' => [
                    'token' => $user->createToken('token')->accessToken,
                    'message' => 'I am user',
                ],
            ]);
        }
        return response()->json([
            'response' => 'error',
            'message' => 'invalid_email_or_password',
        ],400);
    }

    public function logout(Request $request)
    {   
        if(Auth::check() == false)
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        Auth::guard('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            return response()->json(['token' => $token], 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }
    }

    public function user(Request $request)
    {
        if(Auth::check())
        {
            return response()->json([
                'status' => true,
                'response' => Auth::user(),
                'message' => 'Check Success'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Check Error'
            ], 401);
        }
    }
}
