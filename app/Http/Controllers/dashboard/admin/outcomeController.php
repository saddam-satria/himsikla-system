<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\OutcomeDataTable;
use App\Exports\Excel\Outcome;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\FinancialService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class outcomeController extends Controller
{
    private $financialService;
    public function __construct()
    {
        $this->financialService = new FinancialService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OutcomeDataTable $outcomeTable)
    {
        $title = "Data Pengeluaran";
        return $outcomeTable->render("pages.dashboard.admin.finance.outcome.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Pengeluaran";
        return view("pages.dashboard.admin.finance.outcome.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result  = $this->financialService->storeOutcome($request, $request->post("date"), $request->post("total"), $request->post("description"));
        if (!$result) return redirect()->route("dashboard.admin.outcome.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.outcome.index")->with("success", "berhasil menambahkan data pengeluaran");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Edit Pengeluaran";
        $outcome = $this->financialService->outcome($id, array("id", "date", "total", "description"));
        if (is_null($outcome)) return abort(404);
        return view("pages.dashboard.admin.finance.outcome.detail", compact("title", "outcome"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Pengeluaran";
        $outcome = $this->financialService->outcome($id, array("id", "date", "total", "description"));
        if (is_null($outcome)) return abort(404);
        return view("pages.dashboard.admin.finance.outcome.edit", compact("title", "outcome"));
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
        $result  = $this->financialService->updateOutcome($request, $id, $request->post("date"), $request->post("total"), $request->post("description"));
        if (!$result) return redirect()->route("dashboard.admin.outcome.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.outcome.index")->with("success", "berhasil mengupdate data pengeluaran");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result  = $this->financialService->deleteOutcome($id);
        if (!$result) return redirect()->route("dashboard.admin.outcome.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.outcome.index")->with("success", "berhasil menghapus data pengeluaran");
    }
    public function export(Request $request)
    {
        $title = "Data Pengeluaran";
        $outcomes = $this->financialService->outcomes(array("date", "description", "total"));
        $action = $request->get("action");

        if (count($outcomes) <= 0) return redirect()->route("dashboard.admin.outcome.index")->with("error", "Data Masih Kosong, Tidak Dapat Di export");

        if (!is_null($action)) return $this->excelExport($action);



        $pdf = Pdf::loadView("pages.dashboard.admin.finance.outcome.export", compact("title", "outcomes"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data pengeluaran kas" . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
    private function excelExport($action)
    {
        if ($action != "excel") return abort(404);

        return Excel::download(new Outcome(), "data pengeluaran himsi kaliabang.xlsx");
    }
}
