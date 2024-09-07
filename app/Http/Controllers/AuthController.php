<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{

    /**
     * Register a User.
     *
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function register(AuthRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = new User;
        $user->fill($data);
        $user->password = bcrypt(request()->password);
        $user->save();

        return ApiResponseClass::sendResponse($user, 'User registered successfully', 201);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request()->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return ApiResponseClass::throw(
                new Exception('Unauthorized'),
                'Unauthorized',
                401
            );
        }

        return ApiResponseClass::sendResponse(
            $this->respondWithToken($token)->original, 'User logged in'
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return ApiResponseClass::sendResponse(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return ApiResponseClass::sendResponse([], 'User logged out');
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return ApiResponseClass::sendResponse(
            $this->respondWithToken(auth()->refresh())->original,
            'Token refreshed'
        );
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
