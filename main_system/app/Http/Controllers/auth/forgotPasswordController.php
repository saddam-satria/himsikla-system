<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class forgotPasswordController extends Controller
{
    public function resetToken()
    {
        $title = "Reset Password";
        return view("pages.auth.reset_password", compact("title"));
    }
    public function editPassword(Request $request)
    {
        $rules = array("email" => ["required", "email:rfc,dns"], "token" => ["required"]);
        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "email.email" => "format email salah",
        );

        $request->validate($rules, $messages);


        if (!$request->get("token") && !$request->get("email")) return redirect()->route("auth.login.index")->with("error", "token dan email dibutuhkan");
        $user = Member::query()->join("user", "user.id", "=", "member.user_id")->where("email", "=", $request->get("email"))->where("token", "=", $request->get("token"))->first(array("token"));
        if (is_null($user)) return redirect()->route("auth.login.index")->with("error", "terjadi error");


        $title = "Ganti Password";
        return view("pages.auth.forgot_password", compact("title"));
    }
    public function updatePassword(Request $request)
    {
        $rules = array(
            "new_password" => ["required", "min:6"],
            "password_confirmation" => ["required", "same:new_password"]
        );

        $messages = array(
            "same" => "password tidak sama",
            "required" => ":attribute tidak boleh kosong",
            "password.min" => "password harus lebih dari 6"
        );
        $request->validate($rules, $messages);

        if (!$request->get("token") && !$request->get("email")) return redirect()->route("auth.login.index")->with("error", "token dan email dibutuhkan");

        $member = Member::query()->join("user", "user.id", "=", "member.user_id")->where("email", "=", $request->get("email"))->where("token", "=", $request->post("token"))->first(array("user.id"));
        if (is_null($member)) return redirect()->route("auth.login.index")->with("error", "akun tidak ditemukan");

        $data = array(
            "password" => bcrypt($request->post("new_password"))
        );
        $response = User::query()->where("id", "=", $member->id)->update($data) == 1;

        if (!$response) return redirect()->route("auth.login.index")->with("error", "terjadi kesalahan");
        return redirect()->route("auth.login.index")->with("success", "password berhasil di update");
    }
}
