<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\Captcha;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  use Captcha;

  public function __construct(
    private readonly LoginService $loginService,
  ) {}

  public function index()
  {
    return inertia('Auth/Login', [
      'captcha' => $this->generateCaptcha()
    ]);
  }

  public function login(Request $request)
  {
    return $this->loginService->login($request);
  }
}
