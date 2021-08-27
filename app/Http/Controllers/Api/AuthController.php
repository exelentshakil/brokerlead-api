<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ( $user ) {

            $token = $user->createToken('authtoken')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ], 201);
        }

        return response([
            'user' => [],
            'token' => ''
        ], 200);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $user->tokens()->delete();
        $token = $user->createToken('authtoken')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 201);

    }

    public function me(Request $request) {
        $user = $request->user();
        return response([
            'user' => $user,
        ], 200);

    }
    public function logout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();

        return response([
            'succss' => true,
            'data' => []
        ],200);
    }
}
