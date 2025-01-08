<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __construct(private readonly LoginService $loginService)
    {
    }

    public function index()
    {
      return inertia('Auth/Login');
    }

    public function login(Request $request)
    {
        $this->loginService->login($request);
    }
}
