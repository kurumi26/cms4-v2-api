<?php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\AuthRepository;
use App\Http\Resources\Auth\LoginResource;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public $authRepository;
    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = $this->authRepository->login($validated);

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token       = $user->createToken('api-token')->plainTextToken;
        $user->token = $token;

        return new LoginResource($user);
    }
}
