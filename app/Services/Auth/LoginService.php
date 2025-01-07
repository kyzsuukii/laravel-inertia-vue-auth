<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use App\Services\Auth\Traits\AuthenticatesUser;

class LoginService
{
    use AuthenticatesUser;

    public function login(Request $request)
    {
        $request->validate([
            'login' => [
                'required', 
                'string',
            ],
            'password' => ['required', PasswordRule::min(8)->letters()->numbers()->symbols()],
        ]);

        $user = User::where('username', $request->login)
            ->orWhere('email', $request->login)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login' => ['The provided username or email does not exist.'],
            ]);
        }

        if (!Auth::attempt([
            'username' => $request->login,
            'password' => $request->password,
        ]) && !Auth::attempt([
            'email' => $request->login,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials do not match our records.'],
            ]);
        }

        return $this->authenticateAndRedirect($request);
    }
}
