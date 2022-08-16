<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\AttendenceMeetRecapDataTable;
use App\DataTables\AttendenceRecapMeetDataTable;
use App\DataTables\MeetAbsenceDataTable;
use App\Exports\Excel\DetailAbsenceMember;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\AbsenceService;
use App\Models\Meet;
use App\Models\MeetAbsence;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MeetAbsenceController extends Controller
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
    public function index(Request $request, MeetAbsenceDataTable $meetAbsenceTable)
    {
        $id = $request->get("meet");
        $meet = $this->absenceService->meetAbsence();
        $title = "Data Absensi Pertemuan";

        $detailAbsence = DB::table("meet_absence")->selectRaw('count(IF(status = "sakit", 1, null)) AS sick , count(IF(status = "hadir", 1, null)) AS present, count(IF(status = "absen", 1, null)) AS absence, count(IF(status = "ijin", 1, null)) AS permit')->where("meet_id", "=", $id)->first();

        if (is_null($meet)) return redirect()->route("dashboard.admin.meet.index")->with("error", "absensi masih kosong");
        return $meetAbsenceTable->with("id", $id)->render("pages.dashboard.admin.meet.absence.index", compact("title", "meet", "detailAbsence"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->absenceService->createMeetAbsence();
        $meets = $data["meets"];
        $members = $data["members"];
        $reasons = $data["reasons"];
        $title = "Tambah Absensi Pertemuan";
        return view("pages.dashboard.admin.meet.absence.add", compact("title", "members", "meets", "reasons"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->absenceService->storeMeetAbsence($request, $request->post("meet_id"), $request->post("member_id"), $request->post("status"));

        if (!$result) return redirect()->route("dashboard.admin.meet.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet.index")->with("success", "berhasil absen masuk");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Absensi Pertemuan";
        $meet = $this->absenceService->detailMeetAbsence($id);

        if (is_null($meet)) return abort(404);

        return view("pages.dashboard.admin.meet.absence.detail", compact("title", "meet"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Absensi";
        $data = $this->absenceService->getMeetAbsenceByID($id);
        $meet = $data["meet"];
        $reasons = $data["reasons"];

        if (is_null($meet)) return abort(404);

        return view("pages.dashboard.admin.meet.absence.edit", compact("title", "meet", "reasons"));
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
        $data = $this->absenceService->updateMeetAbsence($id, $request->post("status"));
        $result = $data["response"];
        $meet = $data["meet"];
        if (!$result) return redirect(route("dashboard.admin.meet_absence.index") . "?meet=" . $meet->id)->with("error", "terjadi kesalahan");
        return redirect(route("dashboard.admin.meet_absence.index") . "?meet=" . $meet->id)->with("success", "berhasil update absen masuk");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->absenceService->deleteMeetAbsence($id);
        $meet = $result["meet"];

        if (!$result["response"]) return redirect(route("dashboard.admin.meet_absence.index") . "?meet=" . $meet->id)->with("error", "terjadi kesalahan");
        return redirect(route("dashboard.admin.meet_absence.index") . "?meet=" . $meet->id)->with("success", "berhasil menghapus absen masuk");
    }
    public function members(AttendenceRecapMeetDataTable $membersMeetTable)
    {
        $title = "data absensi anggota";

        return $membersMeetTable->render("pages.dashboard.admin.meet.absence.members", compact("title"));
    }
    public function exportByMember(Request $request)
    {
        if (!is_null($request->get("action"))) return $this->excelExport($request->get("action"));

        $title = "rekap absensi pada tanggal " . date_format(date_create("now"), "d-m-Y h:i:s");
        $members = MeetAbsence::query()->join("member", "member.id", "=", "meet_absence.member_id")->groupBy("member.nim", "member.name")->select("member.name", "member.nim", DB::raw('count(IF(meet_absence.status = "hadir", 1, null)) AS present, count(IF(meet_absence.status = "sakit", 1, null)) AS sick, count(IF(meet_absence.status = "absen", 1, null)) AS absence, count(IF(meet_absence.status = "ijin", 1, null)) AS permitted'))->get();
        $pdf = Pdf::loadView("pages.dashboard.admin.meet.absence.export_member", compact("title", "members"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data-rekap-absensi-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
    public function export($meet)
    {
        $meetByID = Meet::query()->where("id", "=", $meet)->first(array("meetName", "id"));

        if (is_null($meet)) return abort(404);

        $title = " Data Absensi Pertemuan " . $meetByID->meetName . " - " . $meetByID->id;
        $members = MeetAbsence::query()->join("member", "member.id", "=", "meet_absence.member_id")->where("meet_absence.meet_id", "=", $meet)->get(array("member.name", "meet_absence.status", "member.nim", "member.occupation", "meet_absence.createdAt"));

        if (count($members) <= 0) return redirect()->route("dashboard.admin.meet_absence.index"  . "?meet=" . $meetByID->id)->with("error", "Data Masih Kosong, Tidak Dapat Di export");


        $pdf = Pdf::loadView("pages.dashboard.admin.meet.absence.export", compact("title", "members"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data absensi pertemuan " . $meetByID->id . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
    private function excelExport($action)
    {
        if ($action != "excel") return abort(404);

        return Excel::download(new DetailAbsenceMember, "data rekap absensi.xlsx");
    }
}
