<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\meetNoteDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\MeetNoteService;
use Illuminate\Http\Request;

class meetNoteController extends Controller
{
    private $meetNoteService;
    public function __construct()
    {
        $this->meetNoteService = new MeetNoteService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(meetNoteDataTable $meetNoteTable)
    {
        $title = " Data Notulensi Pertemuan";
        return $meetNoteTable->render("pages.dashboard.admin.meet.note.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Notulensi Pertemuan";
        $meets = $this->meetNoteService->meetsByStatus(true, array("id", "meetName"));
        return view("pages.dashboard.admin.meet.note.add", compact("title", "meets"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->meetNoteService->storeMeet($request, $request->post("note"), $request->post("meet_id"));

        if (!$result) return redirect()->route("dashboard.admin.meet_note.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet_note.index")->with("success", "sukses menambah notulensi pertemuan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Notulensi Pertemuan";
        $meet = $this->meetNoteService->meetNoteDetail($id, array("note", "meet.meetName"));

        if (is_null($meet)) return abort(404);

        return view("pages.dashboard.admin.meet.note.detail", compact("title", "meet"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        if ($request->get("edit") && $request->get("edit") == "meet") return $this->editMeet($id);

        $title = "Edit Notulensi";
        $meet = $this->meetNoteService->detailNote($id, array("id", "note"));


        if (is_null($meet)) return abort(404);

        return view("pages.dashboard.admin.meet.note.edit", compact("title", "meet"));
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
        if ($request->get("edit") && $request->get("edit") == "meet") return $this->updateMeet($request, $id);

        $result = $this->meetNoteService->updateNote($request, $id, $request->post("note"));
        if (!$result) return redirect()->route("dashboard.admin.meet_note.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet_note.index")->with("success", "sukses mengupdate notulensi pertemuan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->meetNoteService->deleteMeetNote($id);
        if (!$result) return redirect()->route("dashboard.admin.meet_note.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet_note.index")->with("success", "sukses menghapus notulensi pertemuan");
    }
    private function editMeet($id)
    {
        $title = "Edit Pertemuan";
        $meet = $this->meetNoteService->detailNote($id, array("id", "note"));
        $meets = $this->meetNoteService->meetsByStatus(true, array('id', "meetName"));

        return view("pages.dashboard.admin.meet.note.edit_meet", compact("title", "meet", "meets"));
    }
    private function updateMeet(Request $request, $id)
    {
        $result = $this->meetNoteService->updateMeetNote($request, $id, $request->post("meet_id"));
        if (!$result) return redirect()->route("dashboard.admin.meet_note.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.meet_note.index")->with("success", "sukses mengupdate notulensi pertemuan");
    }
}
