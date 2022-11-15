<?php


namespace App\Http\Services\auth;

use App\Http\Services\Service;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ResetPasswordService extends Service
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function resetPassword(Request $request, $id, $password)
    {
        $rules = array(
            "password" => ["required", "min:6"],
            "password_confirmation" => ["required", "same:password"]
        );

        $messages = array(
            "same" => "password tidak sama",
            "required" => ":attribute tidak boleh kosong",
            "password.min" => "password harus lebih dari 6"
        );
        $this->validation($request, $rules, $messages);

        return $this->userRepository->query()->where("id", "=", $id)->update(array("password" => bcrypt($password))) == 1;
    }
}
