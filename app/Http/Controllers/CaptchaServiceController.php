<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaServiceController extends Controller
{
    public function index()
    {
        return view('layout.front');
    }

    public function percoba()
    {
        return view('layout.coba');
    }

    public function masuk()
    {
        return view('components.modal.login');
    }



    public function capthcaFormValidate(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);
        return 'dasboard';
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
