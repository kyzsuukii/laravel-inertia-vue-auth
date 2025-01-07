<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __construct(private readonly RegisterService $registerService)
    {
    }

    public function index()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $this->registerService->register($request);
    }
}
