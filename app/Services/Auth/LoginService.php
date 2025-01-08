<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Traits\AuthenticatesUser;
use App\Traits\Captcha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    use AuthenticatesUser, Captcha;

    public function login(Request $request)
    {
        if (!$this->validateCaptcha($request->captcha)) {
            throw ValidationException::withMessages([
                'captcha' => ['The captcha code is incorrect.'],
            ]);
        }

        $request->validate([
            'login' => 'required|string',
            'password' => ['required', PasswordRule::min(8)->letters()->numbers()->symbols()],
            'captcha' => 'required|string',
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
