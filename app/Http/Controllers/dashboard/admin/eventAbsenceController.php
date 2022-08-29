<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\EventAbsenceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\AbsenceService;
use App\Models\Event;
use App\Models\EventAbsence;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class eventAbsenceController extends Controller
{
    private $absenceService;
    public function __construct()
    {
        $this->absenceService = new AbsenceService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EventAbsenceDataTable $eventAbsenceTable)
    {
        if (!$request->get("event")) return abort(404);

        $id = $request->get("event");

        $event = $this->absenceService->eventAbsence($id);

        if (is_null($event)) return redirect()->route("dashboard.admin.event.index")->with("error", "absensi masih kosong");

        $detailAbsence = DB::table("event_absence")->selectRaw('count(IF(status = "sakit", 1, null)) AS sick , count(IF(status = "hadir", 1, null)) AS present, count(IF(status = "absen", 1, null)) AS absence, count(IF(status = "ijin", 1, null)) AS permit')->where("event_id", "=", $id)->first();
        $title = "Data Absensi Acara";

        return $eventAbsenceTable->with("id", $id)->render("pages.dashboard.admin.event.absence.index", compact("title", "event", "detailAbsence"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Absensi Acara";
        $data = $this->absenceService->createEventAbsence();
        $events = $data["events"];
        $members = $data["members"];
        $reasons = $data["reasons"];
        return view("pages.dashboard.admin.event.absence.add", compact("title", "events", "members", "reasons"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->absenceService->storeEventAbsence($request, $request->post("email"), $request->post("nim"), $request->post("university"), $request->post("isMember"), $request->post("member_id"), $request->post("status"), $request->post("event_id"), $request->post("paid"));

        if (!$result) return redirect()->route("dashboard.admin.event.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.event.index")->with("success", "berhasil di tambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Absen Acara";
        $event = $this->absenceService->detailAbsenceEvent($id, array("event_absence.id AS absence_id", "event_absence.createdAt", "event_absence.status", "event_absence.email", "event_absence.nim", "event_absence.university",  "event.id", "event.location", "event_absence.isPaidOff"));

        if (is_null($event)) return abort(404);

        return view("pages.dashboard.admin.event.absence.show", compact("title", "event"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Absensi';
        $data = $this->absenceService->editEventAbsence($id, array("id", "email", "nim", "university", "isPaidOff"));
        $event = $data["event"];
        $reasons = $data["reasons"];

        if (is_null($event)) return abort(404);

        return view("pages.dashboard.admin.event.absence.edit", compact("title", "event", "reasons"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->absenceService->updateEventAbsence($request, $id, $request->post("email"), $request->post("nim"), $request->post("university"), $request->post("status"), $request->post("paid"));

        $result = $data["response"];
        $event = $data["event"];

        if (!$result) return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("error", "terjadi kesalahan");
        return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("success", "sukses mengupdate peserta");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->absenceService->deleteEventAbsence($id);
        $response = $data["response"];
        $event = $data["event"];

        if (!$response) return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("error", "terjadi kesalahan");
        return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("success", "sukses menghapus peserta");
    }
    public function export($event)
    {
        $eventByID = Event::query()->where("id", "=", $event)->first(array("eventName", "id"));

        if (is_null($event)) return abort(404);
        $title = " Data Absensi Acara " . $eventByID->eventName . " - " . $eventByID->id;
        $members = EventAbsence::query()->where("event_id", "=", $event)->join("event", "event.id", "=", "event_absence.event_id")->get(array("event_absence.id", "event_absence.email", "event_absence.nim", "event_absence.university", "event_absence.createdAt", "event_absence.status"));

        if (count($members) <= 0) return redirect()->route("dashboard.admin.meet_absence.index"  . "?event=" . $eventByID->id)->with("error", "Data Masih Kosong, Tidak Dapat Di export");


        $pdf = Pdf::loadView("pages.dashboard.admin.event.absence.export", compact("title", "members"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data absensi acara " . $eventByID->id . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
    public function paid($id)
    {
        $data = $this->absenceService->paidConfirmation($id);

        $result = $data["response"];
        $event = $data["event"];

        if (!$result) return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("error", "terjadi kesalahan");
        return redirect(route("dashboard.admin.event_absence.index") . "?event=" . $event->id)->with("success", "sukses mengupdate peserta");
    }
}
