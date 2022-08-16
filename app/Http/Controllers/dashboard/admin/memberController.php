<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\MemberDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\MemberService;
use App\Repositories\MemberRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class memberController extends Controller
{
    private $memberService;
    public function __construct()
    {

        $this->memberService = new MemberService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MemberDataTable $memberTable)
    {


        $title = "Data Angota";
        return $memberTable->render("pages.dashboard.admin.member.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Anggota";
        $users = $this->memberService->createMember();
        return view("pages.dashboard.admin.member.add", compact("title", "users"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->memberService->insertMember($request, $request->post("name"), $request->post("nim"), $request->post("phoneNumber"), $request->post("status"), $request->post("occupation"), $request->post("user"), $request->post("address"), $request->post("token"), $request->post("division"), $request->post("periode"), $request->file("image"));
        if ($result) return redirect()->route("dashboard.admin.member.index")->with("success", "berhasil menambahkan anggota");
        return redirect()->route("dashboard.admin.member.index")->with("error", "terjadi kesalahan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->get("edit") && $request->get("edit") == "occupation") return $this->editOccupation($request, $id);
        if ($request->get("edit") && $request->get("edit") == "user") return $this->editUser($request, $id);
        $title = "Detail Anggota";
        $member = $this->memberService->showMemberByID($id);

        if (is_null($member)) return abort(404);

        return view("pages.dashboard.admin.member.show", compact("title", "member"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $title = "Edit Anggota";
        $member = $this->memberService->editMemberByID($id);
        if (is_null($member)) return abort(404);
        return view("pages.dashboard.admin.member.edit", compact("title", "member"));
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


        if ($request->get("edit") && $request->get("edit") == "occupation") return $this->updateOccupation($request, $id);

        if ($request->get("edit") && $request->get("edit") == "user") return $this->updateUser($request, $id);



        $result = $this->memberService->updateMember($request, $id, $request->post("name"), $request->post("nim"), $request->post("phoneNumber"), $request->post("address"), $request->post("periode"));
        if ($result) return redirect()->route("dashboard.admin.member.index")->with("success", "berhasil mengubah data anggota");
        return redirect()->route("dashboard.admin.member.index")->with("error", "data tidak berubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->memberService->deleteMember($request, $id);
        if (!$result)   return redirect()->route("dashboard.admin.member.index")->with("error", "terjadi kesalahan saat menghapus");
        return redirect()->route("dashboard.admin.member.index")->with("success", "berhasil menghapus data anggota");
    }
    private function editOccupation(Request $request, string $id)
    {
        $title = "Ubah Jabatan";
        $member = $this->memberService->editOccupation($id);

        if (is_null($member)) return abort(404);

        return view("pages.dashboard.admin.member.edit_occupation", compact("title", "member"));
    }
    private function updateOccupation(Request $request, string $id)
    {
        $occupation = $request->post("occupation");
        $division = $request->post("division");

        $result = $this->memberService->updateOccupation($id, array("occupation" => $occupation, "division" => $division));


        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.member.show", ["member" => $id])->with("success", "berhasil mengganti jabatan");
    }
    private function editUser(Request $request, $id)
    {
        $title = "Edit User";
        $data = $this->memberService->editUser($id);
        $users = $data["users"];
        $member = $data["member"];


        if (is_null($member)) return abort(404);

        return view("pages.dashboard.admin.member.edit_user", compact("title", "users", "member"));
    }
    private function updateUser(Request $request, $id)
    {
        $data = array(
            "user_id" => $request->post("user")
        );

        $response = $this->memberService->updateUser($data, $id);

        if (!$response) return redirect()->back()->with("error", "terjadi kesalahan");


        return redirect()->route("dashboard.admin.member.show", array("member" => $id))->with("success", "berhasil mengedit user");
    }
    public function export()
    {
        $memberRepository = new MemberRepository();
        $members = $memberRepository->joinUser()->get(array("member.id", "member.name", "member.nim", "member.phoneNumber", "member.occupation", "member.periode", "user.email"));

        if (count($members) <= 0) return redirect()->route("dashboard.admin.member.index")->with("error", "Data Masih Kosong, Tidak Dapat Di export");


        $title = "Data Anggota";
        $pdf = Pdf::loadView("pages.dashboard.admin.member.export", compact("members", "title"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data-anggota-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
}
