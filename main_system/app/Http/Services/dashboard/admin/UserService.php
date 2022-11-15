<?php

namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbstractUserService extends Service
{
}

class UserService extends AbstractUserService
{
    private $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function insert(Request $request, $email, $password, $guest, $gender, $university): bool
    {
        $this->validation(
            $request,
            array(
                "email" => ["required", "email:rfc,dns", "unique:user"],
                "password" => ["required", "min:6"],
                "university" => ["required"]
            ),
            array(
                "required" => ":attribute tidak boleh kosong",
                "email.email" => "format email salah",
                "email.unique" => "email sudah digunakan",
                "password.min" => "password harus lebih dari 6"
            )
        );

        $isGuest = $guest == "on" ? true : false;

        $data = array(
            "email" => $email,
            "password" => bcrypt($password),
            "gender" => $gender,
            "isGuest" => $isGuest,
            "university" => $university,
            "role_id" => $isGuest ? "2" : "1"
        );

        $user = $this->userRepo;
        $result = $this->create($user, $data);
        if ($result) return true;


        return false;
    }
    public function updateUser(Request $request, $id, $email, $gender, $university)
    {
        $rules = array(
            "email" => ["required", "email:rfc,dns", Rule::unique('user')->ignore($id)],
        );


        $this->validation($request, $rules);

        $data = array(
            "email" => $email,
            "gender" => $gender,
            "university" => $university
        );
        $response = $this->userRepo->query()->where("id", "=", $id)->update($data);

        return $response == 1;
    }
    public function deleteUser($id)
    {
        return $this->userRepo->query()->where("id", "=", $id)->delete();
    }
    public function detailUser($id, array $columns = ["*"])
    {
        return $this->userRepo->query()->where("id", "=", $id)->first($columns);
    }
}
