<?php

namespace App\Http\Controllers\dashboard\user;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class profileController extends Controller
{
    public function index()
    {
        $title = "dashboard user";
        return view("pages.dashboard.user.index", compact("title"));
    }
    public function edit()
    {
        $title = "edit profile";
        $gender = array("laki-laki", "perempuan");
        return view("pages.dashboard.user.edit", compact("title", "gender"));
    }
    public function update(Request $request)
    {
        if ($request->get("action") && $request->get("action") == "password") return $this->updatePassword($request);

        $rules = array(
            "email" => ["required", "email:rfc,dns",  Rule::unique('user')->ignore(auth()->user()->id)],
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "email.email" => "format email salah",
            "email.unique" => "email sudah digunakan",
        );

        $request->validate($rules, $messages);


        $data = array(
            "email" => $request->post("email"),
            "gender" => $request->post("gender"),
            "university" =>  $request->post("university")
        );

        $response = User::query()->where("id", "=", auth()->user()->id)->update($data) == 1;

        if (!$response) return redirect()->route("dashboard.user.profile")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.user.profile")->with("success", "berhasil di update");
    }
    private function updatePassword(Request $request)
    {
        $rules = array(
            "password" => ["required"],
            "new_password" => ["required", "min:6"],
            "password_confirmation" => ["required", "same:new_password"]
        );

        $messages = array(
            "same" => "password tidak sama",
            "required" => ":attribute tidak boleh kosong",
            "password.min" => "password harus lebih dari 6"
        );
        $request->validate($rules, $messages);

        $user = User::query()->where("id", "=", auth()->user()->id);
        $prevPassword = $user->first(array("password"));
        $checked = Hash::check($request->post("password"), $prevPassword->password);

        if (!$checked) return redirect()->route("dashboard.user.profile")->with("error", "Password lama tidak sesuai");

        $data = array(
            "password" => bcrypt($request->post("new_password"))
        );

        $response = $user->update($data) == 1;

        if (!$response) return redirect()->route("dashboard.user.profile")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.user.profile")->with("success", "password berhasil di update");
    }
}
