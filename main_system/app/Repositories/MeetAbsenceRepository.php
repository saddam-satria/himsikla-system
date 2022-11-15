<?php

namespace App\Repositories;

use App\Models\MeetAbsence;

class MeetAbsenceRepository extends MeetAbsence
{
    public function joinMeet()
    {
        return $this->query()->join("meet", "meet.id", "=", "meet_absence.meet_id");
    }
    public function joinMember()
    {
        return $this->query()->join("member", "member.id", "=", "meet_absence.member_id");
    }
    public function joinMemberMeet()
    {
        return $this->joinMember()->join("meet", "meet.id", "=", "meet_absence.meet_id");
    }
    public function getMeetAbsenceByID(string $id)
    {
        return $this->query()->where("meet_absence.id", "=", $id);
    }
    public function isMemberAbsence($member_id, $meet_id, array $columns = ["*"])
    {
        return $this->query()->where("meet_id", "=", $meet_id)->where("member_id", "=", $member_id)->first($columns);
    }
}
