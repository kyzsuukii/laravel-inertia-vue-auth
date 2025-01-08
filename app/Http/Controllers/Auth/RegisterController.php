<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\Captcha;
use App\Services\Auth\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use Captcha;

    public function __construct(
        private readonly RegisterService $registerService,
    ) {
    }

    public function index()
    {
        return inertia('Auth/Register', [
            'captcha' => $this->generateCaptcha()
        ]);
    }

    public function register(Request $request)
    {
        return $this->registerService->register($request);
    }
}
