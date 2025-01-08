<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

trait Captcha
{
    public function generateCaptcha()
    {
        $code = Str::random(6);
        Session::put('captcha', $code);

        $image = imagecreatetruecolor(200, 50);
        $bgColor = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgColor);

        $textColor = imagecolorallocate($image, 0, 0, 0);

        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($image, rand(0, 199), rand(0, 49), $textColor);
        }

        for ($i = 0; $i < 5; $i++) {
            $lineColor = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
            imageline($image, rand(0, 199), rand(0, 49), rand(0, 199), rand(0, 49), $lineColor);
        }

        imagestring($image, 5, 50, 15, $code, $textColor);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    public function validateCaptcha($userInput)
    {
        $captcha = Session::get('captcha');
        Session::forget('captcha');

        return $captcha && $userInput === $captcha;
    }
}
