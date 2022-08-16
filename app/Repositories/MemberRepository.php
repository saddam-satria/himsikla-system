<?php


namespace App\Repositories;

use App\Models\Member;
use App\Models\User;


class MemberRepository extends Member
{

    public function joinUser()
    {
        return $this->query()->join("user", "member.user_id", "=", "user.id");
    }
    public function joinUserByMemberID($memberID)
    {
        return $this->joinUser()->where("member.id", "=", $memberID);
    }
    public function members(array $columns = ["*"])
    {
        return $this->query()->get($columns);
    }
    public function member(string $id, array $columns = ["*"])
    {
        return $this->query()->where("id", "=", $id)->get($columns);
    }
    public function joinUserByUserID($userID)
    {
        return $this->joinUser()->where("user.id", "=", $userID);
    }
}
