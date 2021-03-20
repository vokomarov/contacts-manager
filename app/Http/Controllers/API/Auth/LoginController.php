<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (! $this->attempt($request)) {
            return $this->unauthorised();
        }

        if (! ($user = $this->resolve($request)) instanceof User) {
            return $this->unauthorised();
        }

        return $this->authorised($user->createToken('api'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attempt(Request $request): bool
    {
        return Auth::validate($request->only('email', 'password'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\User|null
     */
    protected function resolve(Request $request): ?User
    {
        return User::where('email', $request->get('email'))->first();
    }

    /**
     * @param \Laravel\Sanctum\NewAccessToken $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authorised(NewAccessToken $token): JsonResponse
    {
        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorised(): JsonResponse
    {
        return response()->json([
            'message' => 'Wrong email or password.'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
