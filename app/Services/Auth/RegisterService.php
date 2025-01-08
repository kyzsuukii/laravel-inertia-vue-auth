<?php

namespace App\Services\Auth;

use App\Traits\AuthenticatesUser;
use App\Traits\Captcha;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterService
{
    use AuthenticatesUser, Captcha;

    public function register(Request $request)
    {
        if (!$this->validateCaptcha($request->captcha)) {
            throw ValidationException::withMessages([
                'captcha' => ['The captcha code is incorrect.'],
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', PasswordRule::min(8)->letters()->numbers()->symbols()],
            'captcha' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return $this->authenticateAndRedirect($request);
    }
}
