<?php

namespace App\Http\Services\auth;

use App\Http\Services\Service;
use Illuminate\Http\Request;


class LoginService extends Service
{
    public function login(Request $request,  $email,  $password): array
    {
        $this->validation($request, array(
            "email" => ["required", "email:rfc,dns"],
            "password" => ["required"]
        ));

        $data = array(
            "email" => $email,
            "password" => $password
        );

        return $data;
    }
}
