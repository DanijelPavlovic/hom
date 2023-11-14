<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Response
     */
    public function register(Request $request)
    {
        $this->validateRequest($request, true);

        try {
            $token = hash('sha256', Str::random(60));

            $user = User::create([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'api_token' => $token,
            ]);

            return $this->successfullResponse([
                'user' => $user,
                'token' => 'Bearer ' . $token
            ]);

        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $this->validateRequest($request);

        $user = User::where('email', $request->input('email'))->first();

        if ($user === null) {
            return $this->notFoundResponse('User not found');
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => "Invalid Credential"], 401);
        }

        return $this->successfullResponse([
            'user' => $user,
            'token' => 'Bearer ' . $user->api_token
        ]);
    }

    public function me()
    {
        try {
            return $this->successfullResponse([
                'data' => [
                    'user' => Auth::user()
                ]
            ]);
        } catch (Exception $e) {
            return $this->failResponse($e->getMessage());
        }
    }

    private function validateRequest(Request $request, bool $register = false)
    {
        $rules = [
            'email' => $register ? 'required|email|unique:users' : 'required',
            'password' => $register ? 'required|min:6' : 'required',
        ];

        $this->validate($request, $rules);
    }
}
