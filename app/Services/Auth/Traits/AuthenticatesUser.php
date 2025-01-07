<?php

namespace App\Services\Auth\Traits;

use Illuminate\Http\Request;

trait AuthenticatesUser
{
    protected function authenticateAndRedirect(Request $request)
    {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }
} 