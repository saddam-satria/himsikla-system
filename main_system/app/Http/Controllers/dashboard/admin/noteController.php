<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\NoteDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\NoteService;
use Illuminate\Http\Request;

class noteController extends Controller
{

    protected $noteService;

    public function __construct()
    {
        $this->noteService = new NoteService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NoteDataTable $noteTable)
    {
        $title = "Data Notulensi";
        return $noteTable->render("pages.dashboard.admin.event.note.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Notulensi";
        $events = $this->noteService->events()["events"];
        return view("pages.dashboard.admin.event.note.add", compact("title", "events"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->noteService->insert($request, $request->post("note"), $request->post("event_id"));
        if (!$result) return redirect()->route("dashboard.admin.event_note.index")->with("error", "terjadi kesalahan");


        return redirect()->route("dashboard.admin.event_note.index")->with("success", "berhasil menambahkan notulensi");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Notulensi Acara";
        $event = $this->noteService->detailNote($id)->select("event.eventName AS name", "note.note AS note", "note.id")->first();

        if (is_null($event)) return abort(404);

        return view("pages.dashboard.admin.event.note.show", compact("title", "event"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Notulensi";

        $event_note = $this->noteService->detailNote($id)->select("note.note AS note", "note.id")->first();


        if (is_null($event_note)) return abort(404);

        return view("pages.dashboard.admin.event.note.edit", compact("title", "event_note"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $result = $this->noteService->updateNote($request, $id, $request->post("note"));

        if (!$result) return redirect()->route("dashboard.admin.event_note.index")->with("error", "error, terjadi kesalahan");
        return redirect()->route("dashboard.admin.event_note.index")->with("success", "berhasil mengubah notulensi");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->noteService->destroy($id);
        return redirect()->route("dashboard.admin.event_note.index")->with("success", "berhasil menghapus notulensi");
    }
}
