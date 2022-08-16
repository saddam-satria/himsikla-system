<?php


namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\EventAbsenceRepository;
use App\Repositories\EventRepository;
use App\Repositories\MeetAbsenceRepository;
use App\Repositories\MeetRepository;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;

class AbsenceService extends Service
{
    private $meetRepository;
    private $eventRepository;
    private $memberRepository;
    private $meetAbsenceRepository;
    private $eventAbsenceRepository;
    public function __construct()
    {
        $this->meetRepository = new MeetRepository();
        $this->memberRepository = new MemberRepository();
        $this->eventRepository = new EventRepository();
        $this->meetAbsenceRepository = new MeetAbsenceRepository();
        $this->eventAbsenceRepository = new EventAbsenceRepository();
    }
    public function meetAbsence()
    {
        return $this->meetAbsenceRepository->joinMeet()->first(array("meet.meetName", "meet_absence.createdAt", "meet.id"));
    }
    public function createMeetAbsence()
    {
        return [
            "meets" => $this->meetRepository->query()->where("status", "=", false)->get(["id", "meetName"]),
            "members" => $this->memberRepository->query()->get(["id", "name", "nim"]),
            "reasons" =>  array("sakit", "ijin", "absen", "hadir")
        ];
    }
    public function storeMeetAbsence(Request $request, $meet_id, $member_id, $reason)
    {


        $rules = array(
            "meet_id" => ["required"],
            "member_id" => ["required"],
            "status" => ["required"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong"
        );


        $this->validation($request, $rules, $messages);

        $meet = $this->meetRepository->query()->where("id", "=", $meet_id)->first(array("status", "startAt"));

        if ($meet->status || $meet->startAt >= date("Y-m-d H:i:s")) return false;

        $data = array(
            "meet_id" => $meet_id,
            "member_id" => $member_id,
            "status" => $reason
        );

        $isAbsence = $this->meetAbsenceRepository->query()->where("meet_id", "=", $meet_id)->where("member_id", "=", $member_id)->first(array("id"));

        if (!is_null($isAbsence)) return false;


        $response = $this->meetAbsenceRepository->query()->create($data);

        if (!$response) return false;

        return true;
    }
    public function updateMeetAbsence(string $id, string $status)
    {
        $data = array(
            "status" => $status
        );
        $response = $this->meetAbsenceRepository->getMeetAbsenceByID($id)->update($data);

        return [
            "meet" => $this->meetAbsenceRepository->joinMeet()->where("meet_absence.id", "=", $id)->select("meet.id")->first(),
            "response" => $response
        ];
    }
    public function getMeetAbsenceByID(string $id)
    {
        return [
            "meet" => $this->meetAbsenceRepository->getMeetAbsenceByID($id)->join("member", "member.id", "=", "meet_absence.member_id")->join("meet", "meet.id", "=", "meet_absence.meet_id")->get(array("meet_absence.id", "meet.meetName", "meet.createdAt", "name", "nim"))->first(),
            "reasons" => array("sakit", "ijin", "absen", "hadir")
        ];
    }
    public function detailMeetAbsence(string $id)
    {
        return $this->meetAbsenceRepository->joinMemberMeet()->where("meet_absence.id", "=", $id)->select("meet.meetName", "meet.id", "meet.material", "meet.location", "meet_absence.status",  "meet_absence.createdAt", "member.name", "member.nim")->first();
    }
    public function deleteMeetAbsence(string $id)
    {
        $response = $this->meetAbsenceRepository->getMeetAbsenceByID($id);

        $meet_id = $response->first(array("meet_id as id"));

        return array(
            "meet" => $meet_id,
            "response" => $response->delete(),
        );
    }
    public function createEventAbsence()
    {
        return array(
            "events" => $this->eventRepository->query()->where("status", "=", false)->get(array("id", "eventName", "createdAt")),
            "members" => $this->memberRepository->query()->get(array("id", "name", "nim")),
            "reasons" => array("sakit", "ijin", "absen", "hadir")
        );
    }
    public function storeEventAbsence(Request $request, $email, $nim, $university, $isMember, $member_id, $status, $event_id, $paid)
    {


        $rules = array(
            'email' => ["email:rfc,dns", "nullable", "max:150"],
            'nim' => ["max:10", "nullable"],
            "university" => ["max:150", "nullable"],
            "member_id" => ["required_if:isMember,on"],
            "event_id" => ["required"]
        );

        $messages = array(
            "email" => "format email harus benar",
            "max" => ":attribute melebihi batas karakter",
            "required_if" => "member tidak boleh kosong",
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);

        $event = $this->eventRepository->query()->where("id", "=", $event_id)->first(array("startAt", "status"));
        if ($event->status || $event->startAt >= date("Y-m-d H:i:s")) return false;

        $data = array(
            "event_id" => $event_id,
            "email" => $email,
            "nim" => $nim,
            "university" => $university,
            "status" => $status,
            "isPaidOff" => $paid == "on"
        );

        if ($isMember == "on") {
            $member = $this->memberRepository->query()->where("member.id", "=", $member_id)->join("user", "user.id", "=", "member.user_id")->get(array("member.nim", "user.email"))->first();
            $data["email"] = $member->email;
            $data["nim"] = $member->nim;
            $data["university"] = "UBSI kaliabang";
        };

        $isAbsence = $this->eventAbsenceRepository->query()->where("email", "=", $data["email"])->orWhere("nim", "=", $data["nim"])->where("event_id", "=", $event_id)->first(array("id"));
        if (!is_null($isAbsence)) return false;


        $response = $this->eventAbsenceRepository->query()->create($data);
        if (!$response) return false;

        return true;
    }
    public function eventAbsence($id)
    {
        return $this->eventAbsenceRepository->query()->where("event_absence.event_id", "=", $id)->join("event", "event.id", "=", "event_absence.event_id")->get(array("eventName", "event.startAt AS createdAt", "event.id"))->first();
    }
    public function editEventAbsence($id, array $columns = ["*"])
    {
        return [
            "event" => $this->eventAbsenceRepository->query()->where("id", "=", $id)->get($columns)->first(),
            "reasons" => array("sakit", "ijin", "absen", "hadir")
        ];
    }
    public function detailEventAbsence(array $columns = ["*"])
    {
        return $this->eventAbsenceRepository->query()->join("event", "event.id", "=", "event_absence.event_id")->first($columns);
    }
    public function deleteEventAbsence($id)
    {
        $response = $this->eventAbsenceRepository->query()->where("id", "=", $id);

        return array(
            "event" => $response->select("event_id as id")->first(),
            "response" => $response->delete(),
        );
    }
    public function updateEventAbsence(Request $request, $id, $email, $nim, $university, $status, $paid)
    {

        $rules = array(
            'email' => ["email:rfc,dns", "nullable", "max:150"],
            'nim' => ["max:10", "nullable"],
            "university" => ["max:150", "nullable"],
        );

        $messages = array(
            "email" => "format email harus benar",
            "max" => ":attribute melebihi batas karakter"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "email" => $email,
            "nim" => $nim,
            "university" => $university,
            "status" => $status,
            "isPaidOff" => $paid == "on"
        );

        $response = $this->eventAbsenceRepository->query()->where("id", "=", $id);

        return array(
            "response" => $response->update($data) == 1,
            "event" => $response->select("event_id as id")->first()
        );
    }
    public function paidConfirmation($id)
    {
        $response = $this->eventAbsenceRepository->query()->where("id", "=", $id);
        $data = array("isPaidOff" => true);

        return array(
            "response" => $response->update($data) == 1,
            "event" => $response->select("event_id as id")->first()
        );
    }
}
