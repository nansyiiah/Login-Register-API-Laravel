<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => '',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'username' => 'required|unique:users'
        ]);

        if($validator->fails()){
            return response()->json($validator->messages());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            // 'username' => request('username'),
        ]);

        

        if($user){
            return response()->json(['message' => 'Registration Successfully', 'user' => $user]);
        }else{
            return response()->json(['message' => 'Registration Failed']);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Success', 'token' => $token, 'data' => auth()->user()['name']]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(['data' => auth()->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    public function change_password($id)
    {
        $validator = Validator::make(request()->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error', 'errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if(Hash::check(request()->old_password, $user->password)){
            $user->password = Hash::make(request('new_password'));
            $user->save();
            return response()->json(['message' => 'Password Change Successfully !'], 200);
        }else{
            return response()->json(['message' => 'Error'], 422);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
