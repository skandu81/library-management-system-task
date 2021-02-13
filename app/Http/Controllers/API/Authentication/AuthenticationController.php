<?php

namespace App\Http\Controllers\API\Authentication;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Finally_;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Check if user already registered 
        $user = User::where('email', $request->email)->first();
        if($user)
        return response()->json(['status' => false, 'message' => 'User already exists']);

        // Register new user 
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'User Registered Successfully.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Check First User Exist Or Not 
        $user = User::where('email', $request->email)->first();
        if ($user) {

            // Check credentials are valid or not 
            $credentials = request(['email', 'password']);
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['status' => false, 'message' => 'Invalid Password']);
            }

            // Return Token If Success 
            return $this->respondWithToken($token);


        } else {
            return response()->json(['status' => false, 'message' => 'User does not exists']);
        }
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
