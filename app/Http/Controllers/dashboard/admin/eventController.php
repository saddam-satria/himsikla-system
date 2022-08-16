<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\CertificateDataTable;
use App\DataTables\EventDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\EventService;
use Illuminate\Http\Request;

class eventController extends Controller
{
    private  $pageName = "pages.dashboard.admin";
    private  $eventService;
    public function __construct()
    {
        $this->eventService = new EventService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EventDataTable $eventTable, CertificateDataTable $certificateTable)
    {
        if ($request->get("action") && $request->get("action") == "certificates") return $this->certificates($certificateTable);

        $title = "Data Acara";
        return $eventTable->render($this->pageName . ".event.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Acara";
        return view($this->pageName . ".event.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = $this->eventService->insert($request, $request->post("name"), $request->post("startAt"), $request->post("endAt"), $request->post("description"), $request->post("isGeneral"), $request->post("isFree"), $request->post("price"), $request->post("isOnline"), $request->post("location"), $request->file("banner"), $request->post("detailLocation"), $request->post("feedback"), $request->post("payment"), $request->post("contact"));
        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");


        return redirect()->route("dashboard.admin.event.index")->with("success", "berhasil menambahkan data acara");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Acara";
        $service = $this->eventService->showEventByID($id);
        $event = $service["event"]->first(array("id", "eventName", "startAt", "endAt", "price", "isOnline", "isGeneral", "location", "description", "banner", "detailLocation", 'status', "feedback",  "payment", "contactPerson"));
        $certificate = $service["certificate"];

        if (is_null($event)) return abort(404);

        return view("pages.dashboard.admin.event.show", compact("title", "event", "certificate"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->get("action") && $request->get("action") == "banner") return $this->editBanner($id);
        if ($request->get("action") && $request->get("action") == "certificate" && !$request->get("edit")) return $this->editCertificate($id);
        if ($request->get("action") && $request->get("action") == "certificate" && $request->get("edit") && $request->get("edit") == "event") return $this->editCertificateEvent($id);

        $title = "Edit Acara";
        $event = $this->eventService->showEventByID($id)["event"]->first(array("id", "eventName", "startAt", "endAt", "price", "location", "description", "isOnline", "detailLocation", "feedback", "payment", "contactPerson"));

        if (is_null($event)) return abort(404);
        return view("pages.dashboard.admin.event.edit", compact("title", "event"));
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
        if ($request->get("action") && $request->get("action") == "banner") return $this->updateBanner($request, $id);
        if ($request->get("action") && $request->get("action") == "certificate" && !$request->get("edit")) return $this->updateCertificate($request, $id);
        if ($request->get("action") && $request->get("action") == "certificate" && $request->get("edit") && $request->get("edit") == "event") return $this->updateEventCertificate($request, $id);

        if ($request->get("finished") && $request->get("finished") == true) return $this->updateFinishingEvent($id);

        $result = $this->eventService->updateEventByID(
            $request,
            $id,
            $request->post("name"),
            $request->post("startAt"),
            $request->post("endAt"),
            $request->post("description"),
            $request->post("price"),
            $request->post("isGeneral"),
            $request->post("isOnline"),
            $request->post("location"),
            $request->post("isFree"),
            $request->post("detailLocation"),
            $request->post("feedback"),
            $request->post("payment"),
            $request->post("contact")
        );
        if (!$result) return redirect()->route("dashboard.admin.event.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.event.index")->with("success", "berhasil mengedit acara");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->eventService->deleteEventByID($id);

        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.event.index")->with("success", "berhasil menghapus data");
    }
    private function certificates(CertificateDataTable $certificateTable)
    {
        $title = "Data Sertifikat";
        return $certificateTable->render("pages.dashboard.admin.event.certificate.index", compact("title"));
    }
    public function createCertificate()
    {
        $title = "Tambah Sertifikat";
        $events = $this->eventService->events(array("event.id", "eventName"));
        return view("pages.dashboard.admin.event.certificate.add", compact("title", "events"));
    }
    public function storeCertificate(Request $request)
    {
        $result =  $this->eventService->storeCertificate($request, $request->post("link"), $request->post("event_id"));

        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");


        return redirect(route("dashboard.admin.event.index") . "?action=certificates")->with("success", "berhasil menambahkan sertifikat baru");
    }
    private function editBanner($id)
    {
        $title = "Edit Poster Acara";
        $event = $this->eventService->editBanner($id);

        if (is_null($event)) return abort(404);

        return view("pages.dashboard.admin.event.edit_banner", compact("title", "event"));
    }
    private function updateBanner(Request $request, $id)
    {
        $result = $this->eventService->updateBanner($request, $id, $request->file("banner"));
        if (!$result) return redirect()->back()->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.event.show", ["event" => $id])->with("success", "berhasil mengedit poster");
    }
    private function editCertificate(string $id)
    {
        $certificate = $this->eventService->editCertificate($id)->get(["link", "id"])->first();

        if (is_null($certificate)) return abort(404);

        $title  = "Edit Sertifikat";
        return view("pages.dashboard.admin.event.certificate.edit", compact("title", "certificate"));
    }
    private function editCertificateEvent($id)
    {
        $title  = "Edit Acara";
        $certificate = $this->eventService->editCertificate($id)->get(["link", "id"])->first();


        if (is_null($certificate)) return abort(404);

        $events = $this->eventService->events(array("id", "eventName"));
        return view("pages.dashboard.admin.event.certificate.edit_event", compact("title",  "events", "certificate"));
    }
    private function updateCertificate(Request $request, string $id)
    {
        $link  = $request->post("link");
        $result = $this->eventService->updateCertificate($request, $id, array("link" => $link));
        $redirect = redirect(route("dashboard.admin.event.index") . "?action=certificates");

        if (!$result) return $redirect->with("error", "terjadi kesalahan");
        return $redirect->with("success", "berhasil mengedit link sertifikat");
    }
    private function updateEventCertificate(Request $request, string $id)
    {
        $event = $request->post("event_id");

        $result = $this->eventService->updateCertificate($request, $id, array("event_id" => $event), "event");
        $redirect = redirect(route("dashboard.admin.event.index") . "?action=certificates");

        if (!$result) return $redirect->with("error", "terjadi kesalahan");
        return $redirect->with("success", "berhasil mengedit acara sertifikat");
    }
    public function destroyCertificate(string $id)
    {
        $result = $this->eventService->destroyCertificate($id);

        $redirect = redirect(route("dashboard.admin.event.index") . "?action=certificates");
        if (!$result) return $redirect->with("error", "terjadi kesalahan");
        return $redirect->with("success", "berhasil meghapus sertifikat");
    }
    private function updateFinishingEvent($id)
    {
        $result = $this->eventService->finishingEvent($id);
        $redirect = redirect()->route("dashboard.admin.event.index");
        if (!$result) return $redirect->with("error", "terjadi kesalahan");
        return $redirect->with("success", "berhasil mengubah acara menjadi selesai");
    }
}
