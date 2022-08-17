<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\EventAbsence;
use App\Models\gallery;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class landingPageController extends Controller
{
    public function homepage(Request $request)
    {
        $title = "Beranda";
        $events = Event::query()->orderBy("createdAt", "DESC")->take(8)->where("isGeneral", "=", true)->get(array("id", "eventName", "banner", "startAt", "location",  "isOnline", "price"));
        $total_event = DB::table("event")->where("status", "=", true)->count();
        $total_meet = DB::table("meet")->where("status", "=", true)->count();
        $total_user = DB::table("user")->count();
        $query = $request->get("query");

        $members = $this->getMembers($query);

        $galleries = gallery::query()->orderBy("createdAt", "DESC")->take(6)->get(array("image"));
        $divisions = array("rsdm", "kominfo", "pendidikan", "litbang");


        return view("pages.landing_page.homepage", compact("title", "events", "total_event", "total_meet", "total_user", "divisions", "members", "galleries"));
    }
    public function gallery()
    {
        $title = "Foto Foto HIMSI KALIABANG";
        $galleries = gallery::query()->get(array("image"));

        return view("pages.landing_page.gallery", compact("title", "galleries"));
    }
    public function events(Request $request)
    {
        $title = "Foto Foto HIMSI KALIABANG";
        $columns = array("id", "eventName", "banner", "startAt", "location", "isOnline", "price");
        $events = Event::query()->get($columns);
        $slides  = [];
        $query = $request->get("query");
        $eventsToday = DB::table("event")->whereRaw("DATE(startAt) = CURDATE()")->get(array("banner", "eventName", "id"));


        if (!is_null($query)) {
            $events = Event::query()->where("eventName", "like", '%' . $query . '%')->get($columns);
        }



        return view("pages.landing_page.events", compact("title", "events", "eventsToday"));
    }
    public function event($id)
    {
        $title = "Acara " . $id;
        $event = Event::query()->where("id", "=", $id)->first(array("banner", "eventName", "id", "startAt", "description", "price", "isOnline", "detailLocation", "feedback", "location", "payment", "createdAt", "contactPerson", "status", "endAt"));
        if (is_null($event)) return abort(404);

        $contactPerson = $event->contactPerson;


        if (is_null($event->contactPerson)) {
            $member = Member::query()->where("occupation", "=", "ketua koordinator rsdm")->first(array("phoneNumber", "occupation"));
            $contactPerson = $member->phoneNumber . " - " . $member->occupation;
        }

        return view("pages.landing_page.event", compact("title", "event", "contactPerson"));
    }
    private function getMembers($query)
    {
        if (!is_null($query) && $query == "member")  return Member::all(array("name", "occupation"));

        return Member::where("periode", "=", date_format(date_create("now"), "Y") - 1 . "-" . date_format(date_create("now"), "Y"))->where('occupation', 'LIKE', '%' . "ketua" . '%')->orWhere("occupation", "=", "bendahara")->orWhere("occupation", "=", "sekretaris")->get(array("name", "occupation"));
    }
    public function about(Request $request)
    {
        $title = "Tentang HIMSI KLA";
        $divisions = array("rsdm", "kominfo", "pendidikan", "litbang");
        $galleries = gallery::query()->orderBy("createdAt", "DESC")->take(6)->get(array("image"));
        $query = $request->get("query");
        $members = Member::all(array("name", "occupation"));
        return view("pages.landing_page.about", compact("title", "divisions", "galleries", "members"));
    }
    public function emailRegister($id, Request $request)
    {
        $title = "Email Pendaftaran";
        $event = Event::query()->where("id", "=", $id)->first(array("id", "status", "startAt"));
        if (is_null($event) || $event->status) return abort(404);
        if (date("Y-m-d H:i:s") >= $event->startAt) return abort(404);

        return view("pages.landing_page.event.email_register", compact("title", "event"));
    }
    public function createRegister($id, Request $request)
    {
        $title = "Pendaftaran";
        $event = Event::query()->where("id", "=", $id)->first(array("id", "status", "eventName", "contactPerson", "price", "startAt"));

        if (is_null($event) || $event->status) return abort(404);


        $rules = array("email" => ["required", "email:rfc,dns"]);
        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "email.email" => "format email salah",
        );
        $request->validate($rules, $messages);

        $contactPerson = $event->contactPerson;

        if (is_null($event->contactPerson)) {
            $member = Member::query()->where("occupation", "=", "ketua koordinator rsdm")->first(array("phoneNumber", "occupation"));
            $contactPerson = $member->phoneNumber . " - " . $member->occupation;
        }


        $email = $request->get("email");

        $absence = EventAbsence::query()->where("email", "=", $email)->where("event_id", "=", $id)->first(array("id", "isPaidOff"));

        if (date("Y-m-d H:i:s") >= $event->startAt && is_null($absence)) return abort(404);

        if (is_null($absence)) return view("pages.landing_page.event.register", compact("title", "event", "email"));

        $events = EventAbsence::query()->where("email", "=", $email)->join("event", "event.id", "=", "event_absence.event_id")->get(array("event.id", "eventName", "banner", "startAt", "location",  "isOnline", "price"));

        return view("pages.landing_page.event.register_success", compact("title", "event", "absence", "events", "contactPerson"));
    }
    public function register($id, Request $request)
    {

        $rules = array(
            'nim' => ["max:10", "required"],
            "university" => ["max:150", "required"],
        );

        $messages = array(
            "email" => "format email harus benar",
            "max" => ":attribute melebihi batas karakter",
            "required" => ":attribute tidak boleh kosong"
        );

        $request->validate($rules, $messages);
        $data = array(
            "event_id" => $id,
            "email" => $request->post("email"),
            "nim" => $request->post("nim"),
            "university" => $request->post("university"),
            "isPaidOff" => false
        );
        $absence = EventAbsence::query()->where("email", "=", $data["email"])->where("event_id", "=", $id)->first(array("id"));

        if (!is_null($absence)) return redirect(route("event.register.create", $id) . "?email=" . $data["email"]);


        EventAbsence::query()->create($data);
        return redirect(route("event.register.create", $id) . "?email=" . $data["email"]);
    }
    public function createAbsence(Request $request)
    {
        $title = "Absensi Acara";

        $absenceEvent = EventAbsence::query()->join("event", "event_absence.event_id", "=", "event.id")->where("event_absence.id", "=", $request->get("id"))->first(array("eventName", "event.id as eventID", "event_absence.id", "event_absence.status",  "event.price", "event.contactPerson", "event_absence.isPaidOff", "event_absence.email", "startAt", "event.status as eventStatus", "feedback"));

        if (is_null($absenceEvent)) return abort(404);
        if (!$absenceEvent->isPaidOff) return redirect(route("event.register.create", $absenceEvent->eventID) . "?email=" . $absenceEvent->email);

        $events = EventAbsence::query()->where("email", "=", $absenceEvent->email)->join("event", "event.id", "=", "event_absence.event_id")->get(array("event.id", "eventName", "banner", "startAt", "location",  "isOnline", "price"));


        $certificate = null;
        if (!is_null(Certificate::query()->where("event_id", "=", $absenceEvent->eventID)->first(array("link")))) {
            $certificate = Certificate::query()->where("event_id", "=", $absenceEvent->eventID)->first(array("link"));
        }

        return view("pages.landing_page.event_absence", compact("title", "absenceEvent", "events", "certificate"));
    }
    public function absence(Request $request)
    {
        $absenceEvent = EventAbsence::query()->join("event", "event_absence.event_id", "=", "event.id")->where("event_absence.id", "=", $request->get("id"))->first(array("startAt", "event_absence.id", "event.status", "isPaidOff", "event.id AS eventID"));
        if (is_null($absenceEvent) || !$absenceEvent->isPaidOff) return abort(404);

        if ($absenceEvent->startAt >= date("Y-m-d H:i:s") || $absenceEvent->status) return abort(404);

        $data = array(
            "status" => "hadir"
        );
        EventAbsence::query()->where("id", "=", $absenceEvent->id)->update($data);

        return redirect(route("event.absence.create") . "?id=" . $absenceEvent->id);
    }
}
