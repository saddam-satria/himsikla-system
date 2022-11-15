<?php

namespace App\Http\Controllers\dashboard\member;

use App\DataTables\memberMeetAbsenceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\member\MeetService;
use App\Models\Meet;
use App\Models\MeetAbsence;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


class meetController extends Controller
{

    private $meetService;

    public function __construct()
    {
        $this->meetService = new MeetService;
    }
    public function index()
    {
        $title = "dashboard profil anggota";
        $meets = Meet::with(array("absence" => function ($query) {
            $query->limit(3)->orderBy("createdAt");
        }))->get(array("meetName", "material", "description", "status", "startAt", "endAt", "id", "isOnline", "price", "detailLocation"));

        return view("pages.dashboard.user.member.meet.index", compact("title", "meets"));
    }
    public function show($id)
    {
        $title = "dashboard profil anggota";
        $meet = $this->meetService->getMeetWithNoteAbsence($id);
        if (is_null($meet)) return abort(404);

        return view("pages.dashboard.user.member.meet.show", compact("title", "meet"));
    }
    public function absence(memberMeetAbsenceDataTable $absenceTable)
    {
        $title = "dashboard absensi pertemuan";
        return $absenceTable->render("pages.dashboard.user.member.meet.absence", compact("title"));
    }
    public function present($hash)
    {


        try {
            $meet_id = Crypt::decrypt($hash);
        } catch (DecryptException $error) {
            throw abort(403);
        }

        $meet = Meet::query()->where("id", "=", $meet_id)->first(array("id", "status", "startAt"));

        if (is_null($meet)) return redirect()->route("dashboard.user.member.absence")->with("error", "Pertemuan tidak ditemukan");

        if ($meet->startAt >= date("Y-m-d H:i:s")) return abort(404);


        if ($meet->status == 1) return redirect()->route("dashboard.user.member.absence")->with("error", "Pertemuan sudah selesai");

        $isAbsence = MeetAbsence::query()->where("member_id", "=", auth()->user()->member->id)->where("meet_id", "=", $meet->id)->first(array("id"));
        if (!is_null($isAbsence)) return redirect()->route("dashboard.user.member.absence")->with("error", "Anda Sudah Absen");



        $data = array(
            'status' => "hadir",
            "meet_id" => $meet->id,
            "member_id" => auth()->user()->member->id
        );

        $result = MeetAbsence::query()->create($data);

        if (!$result) return redirect()->route("dashboard.user.member.absence")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.user.member.absence")->with("success", "Berhasil Absen Pertemuan");
    }
}
