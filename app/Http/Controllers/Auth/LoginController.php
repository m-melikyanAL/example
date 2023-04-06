<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
    public const VALIDATION_MESSAGE = 'Invalid Username and/or Password';

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::where('username', $request->input('username'))
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, self::VALIDATION_MESSAGE);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, self::VALIDATION_MESSAGE);
        }

        return response()->json([
            'token' => $user->createToken(
                name: 'api',
                expiresAt: now()->addDays(7)->addMinutes(30)
            )
                ->plainTextToken,
        ]);
    }
}
