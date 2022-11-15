<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\DocumentDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\DocumentService;
use Illuminate\Http\Request;

class documentController extends Controller
{
    private $documentService;
    public function __construct()
    {
        $this->documentService = new DocumentService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DocumentDataTable $documentTable)
    {
        $title = "Data Dokumen";
        return $documentTable->render("pages.dashboard.admin.document.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Dokumen";
        return view("pages.dashboard.admin.document.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->documentService->storeDocument($request, $request->post("name"), $request->file("document"));
        if (!$result) return redirect()->route("dashboard.admin.document.index")->with("error", "terjadi kesalahan");

        return redirect()->route("dashboard.admin.document.index")->with("success", "sukses menambahkan dokumen");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Dokumen";
        $document = $this->documentService->detailDocument($id, array("document", "documentName", "createdAt", "id"));

        if (is_null($document)) return abort(404);

        return view("pages.dashboard.admin.document.detail", compact("title", "document"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Update Dokumen";
        $document = $this->documentService->detailDocument($id, array("documentName", "id"));
        if (is_null($document)) return abort(404);

        return view("pages.dashboard.admin.document.edit", compact("title", "document"));
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

        $result = $this->documentService->updateDocument($request, $id, $request->post("name"));
        if (!$result) return redirect()->route("dashboard.admin.document.index")->with("error", "terjadi kesalahan");

        return redirect()->route("dashboard.admin.document.index")->with("success", "sukses mengupdate dokumen");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->documentService->deleteDocument($id);

        if (!$result) return redirect()->route("dashboard.admin.document.index")->with("error", "terjadi kesalahan saat menghapus dokumen");
        return redirect()->route("dashboard.admin.document.index")->with("success", "sukses menghapus dokumen");
    }
}
