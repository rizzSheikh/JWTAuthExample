<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6'
        ]);

        $token = auth()->attempt($validator->validated());
        // $token = JWTAuth::attempt($validator->validated());

        if (!$token) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            return $this->respondWithToken($token);
        }

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => new \stdClass(),
                'message' => $validator->errors()->getMessages()
            ]);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            //  ['password' => bcrypt($request->password)],
            ['password' => Hash::make($request->password)]
        ));

        return response()->json([
            'status' => true,
            'data' => $user,
            'message' => 'User Registered Successfully'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
