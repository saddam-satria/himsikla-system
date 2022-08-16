<?php

namespace App\Http\Services\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbstractAuth
{
    public static function login(Request $request, $email, $password)
    {
    }
    public static function register()
    {
    }
    public static function logout()
    {
    }
    public static function redirect()
    {
    }
}


class AuthService extends AbstractAuth
{
    public static function login(Request $request,  $email,  $password): bool
    {
        $loginService = new LoginService();
        $data = $loginService->login($request, $email, $password);


        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return true;
        };

        return false;
    }
}
