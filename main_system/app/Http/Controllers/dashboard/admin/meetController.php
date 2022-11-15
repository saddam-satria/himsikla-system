<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\MeetDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\MeetService;
use Illuminate\Http\Request;

class meetController extends Controller
{
    private $meetService;
    public function __construct()
    {
        $this->meetService = new MeetService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MeetDataTable $meetTable)
    {
        $title = "Data Pertemuan";
        return $meetTable->render("pages.dashboard.admin.meet.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Pertemuan";
        return view("pages.dashboard.admin.meet.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->meetService->insert($request, $request->post("name"), $request->post("material"), $request->post("startAt"), $request->post("endAt"), $request->post("isOnline"), $request->post("location"), $request->post("description"), $request->file("banner"), $request->post("price"), $request->post("detailLocation"));

        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet.index")->with("success", "berhasil menambahkan data pertemuan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Pertemuan";
        $meet = $this->meetService->showMeet($id);

        if (is_null($meet)) return abort(404);
        return view("pages.dashboard.admin.meet.detail", compact("title", "meet"));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meet = $this->meetService->showMeet($id);

        if (is_null($meet)) return abort(404);
        $title = "Update Pertemuan";
        return view("pages.dashboard.admin.meet.edit", compact("title", "meet"));
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

        if ($request->get("finished") && $request->get("finished") == true) return $this->updateFinishingMeet($id);

        $result = $this->meetService->updateMeet($request, $id, $request->post("name"), $request->post("material"), $request->post("startAt"), $request->post("endAt"), $request->post("isOnline"), $request->post("location"), $request->post("description"), $request->file("banner"), $request->post("price"), $request->post("detailLocation"));
        if (!$result) return redirect()->route("dashboard.admin.meet.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet.index")->with("success", "berhasil mengupdate data pertemuan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->meetService->destroyMeet($id);
        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet.index")->with("success", "berhasil menghapus data pertemuan");
    }
    private function updateFinishingMeet($id)
    {
        $result = $this->meetService->finishingMeet($id);
        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet.index")->with("success", "berhasil mengubah status pertemuan menjadi selesai");
    }
}
