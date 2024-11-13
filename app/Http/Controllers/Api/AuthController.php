<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (! Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->success(
            'Authenticated',
            [
                'token' => $user->createToken(
                    "Token for {$user->email}",
                    ['*'],
                    now()->addMonth())->plainTextToken
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Logout successfully');
    }
}
