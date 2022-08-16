<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\alumniDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\AlumniService;
use Illuminate\Http\Request;

class alumniController extends Controller
{
    private $alumniService;

    public function __construct()
    {
        $this->alumniService = new AlumniService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(alumniDataTable $alumniTable)
    {
        $title = "Data Alumni";
        return $alumniTable->render("pages.dashboard.admin.alumni.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Alumni";
        return view("pages.dashboard.admin.alumni.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->alumniService->storeAlumni($request, $request->post("name"), $request->post("periode"), $request->file("image"), $request->post("occupation"));

        if (!$result) return redirect()->route("dashboard.admin.alumni.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.alumni.index")->with("success", "berhasil menambahkan data alumni");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Alumni";
        $alumni = $this->alumniService->detailAlumni($id, array("id", "name", "periode", "image", "occupation"));
        return view("pages.dashboard.admin.alumni.detail", compact("title", "alumni"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Alumni";
        $alumni = $this->alumniService->detailAlumni($id, array("id", "name", "periode", "image", "occupation"));
        return view("pages.dashboard.admin.alumni.edit", compact("title", "alumni"));
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
        $result = $this->alumniService->updateAlumni($request, $id, $request->post("name"), $request->post("periode"), $request->file("image"), $request->post("occupation"));

        if (!$result) return redirect()->route("dashboard.admin.alumni.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.alumni.index")->with("success", "berhasil mengupdate data alumni");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->alumniService->deleteAlumni($id);
        if (!$result) return redirect()->route("dashboard.admin.alumni.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.alumni.index")->with("success", "berhasil menghapus data alumni");
    }
}
