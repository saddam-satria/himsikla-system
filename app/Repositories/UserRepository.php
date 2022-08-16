<?php


namespace App\Repositories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends User
{

    public function members()
    {
        return Member::query();
    }
    public function userAll()
    {
        return $this->query()->select("user.id", "user.email", "user.university", "user.isGuest", "user.gender", "user.createdAt", "user.updatedAt")->where("role_id", "!=", 99);
    }
    public function joinMember()
    {
        return $this->query()->join("member", "member.user_id", "=", "user.id");
    }
    public function userNotInMember()
    {
        return DB::table("user")->whereNotIn("id", $this->members()->get(["user_id"]))->where("isGuest", "=", false)->where("role_id", "!=", 99);
    }
}
