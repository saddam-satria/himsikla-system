<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logoutCurrentDevice();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect()->route("auth.login.index")->with('success', 'berhasil logout');
    }
}
