<?php

namespace App\Http\Controllers;

use App\Traits\Captcha;

class CapthaController extends Controller
{
    use Captcha;

    public function generate()
    {
        return response()->json([
            'captcha' => $this->generateCaptcha()
        ]);
    }
}
