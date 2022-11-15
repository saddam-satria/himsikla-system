<?php

namespace App\Http\Controllers\dashboard\member;

use App\DataTables\memberEventAbsenceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\member\EventService;
use App\Models\Event;
use App\Models\EventAbsence;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class eventController extends Controller
{
    private $eventService;
    public function __construct()
    {
        $this->eventService = new EventService();
    }
    public function index()
    {
        $title = "dashboard user acara";
        $events = $this->eventService->getEvents(array("eventName", "id", "startAt", "endAt", "price", "status", "description", "banner", "isOnline", "detailLocation"));
        return view("pages.dashboard.user.member.event.index", compact("title", "events"));
    }
    public function show($id)
    {
        $title = "dashboard detail event";
        $event = $this->eventService->getEventByCertificateAbsenceNote($id);
        return view("pages.dashboard.user.member.event.show", compact("title", "event"));
    }

    public function absence(memberEventAbsenceDataTable $absenceTable)
    {
        $title = "dashboard absensi acara";
        return $absenceTable->render("pages.dashboard.user.member.event.absence", compact("title"));
    }
    public function present($hash, Request $request)
    {

        try {
            $event_id = Crypt::decrypt($hash);
        } catch (DecryptException $error) {
            throw abort(403);
        }

        $event = Event::query()->where("isGeneral", "=", false)->where("id", "=", $event_id)->first(array("id", "status", "startAt"));
        if (is_null($event)) return redirect()->route("dashboard.user.member.event.absence")->with("error", "Pertemuan tidak ditemukan");

        if ($event->startAt >= date("Y-m-d H:i:s")) return abort(404);

        if ($event->status == 1) return redirect()->route("dashboard.user.member.event.absence")->with("error", "Pertemuan sudah selesai");

        $currentUser = auth()->user();
        $isAbsence = EventAbsence::query()->where("email", "=", $currentUser->email)->where("event_id", "=", $event->id)->first(array("id"));

        if (!is_null($isAbsence)) return redirect()->route("dashboard.user.member.event.absence")->with("error", "Anda Sudah Absen");



        $data = array(
            "email" => $currentUser->email,
            "nim" => $currentUser->member->nim,
            "university" => $currentUser->university,
            "status" => "hadir",
            "event_id" => $event->id
        );

        $result = EventAbsence::query()->create($data);

        if (!$result) return redirect()->route("dashboard.user.member.event.absence")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.user.member.event.absence")->with("success", "Berhasil Absen Acara");
    }
}
