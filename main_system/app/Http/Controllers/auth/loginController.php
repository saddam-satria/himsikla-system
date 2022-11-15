<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Services\auth\AuthService;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function index()
    {
        $title = "Login";
        return view("pages.auth.login", compact("title"));
    }
    public function login(Request $request)
    {
        $response = AuthService::login($request, $request->post("email"), $request->post("password"));

        if ($response) return redirect()->route("dashboard.user.profile");

        return redirect()->back()->with("error", "akun tidak dapat ditemukan di system");
    }
}
