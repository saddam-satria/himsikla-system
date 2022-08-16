<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\IncomeDataTable;
use App\Exports\Excel\Income;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\FinancialService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class incomeController extends Controller
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
    public function index(IncomeDataTable $incomeTable)
    {
        $title = "Data Pemasukan";
        return $incomeTable->render("pages.dashboard.admin.finance.income.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Data Pemasukan";
        return view("pages.dashboard.admin.finance.income.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->financialService->storeIncome(true, $request, $request->post("date"), $request->post("total"), $request->post("description"));


        if (!$result) return redirect()->route("dashboard.admin.income.index")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.income.index")->with("success", "sukses menambahkan data pemasukan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Pemasukan";
        $income = $this->financialService->income($id, array("id", "date", "total", "description"));
        if (is_null($income)) return abort(404);
        return view("pages.dashboard.admin.finance.income.detail", compact("title", "income"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Pemasukan";
        $income = $this->financialService->income($id, array("id", "total", "description", "date"));
        if (is_null($income)) return abort(404);
        return view("pages.dashboard.admin.finance.income.edit", compact("title", "income"));
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
        $result = $this->financialService->updateIncome(true, $request, $id, $request->post("date"), $request->post("total"), $request->post("description"));
        if (!$result) return redirect()->route("dashboard.admin.income.index")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.income.index")->with("success", "sukses mengupdate data pemasukan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->financialService->deleteIncome(true, $id);
        if (!$result) return redirect()->route("dashboard.admin.income.index")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.income.index")->with("success", "sukses menghapus data pemasukan");
    }
    public function export(Request $request)
    {
        $action = $request->get("action");



        $title = "Data Pendapatan";
        $incomes = $this->financialService->incomes(array("date", "description", "total"));


        if (count($incomes) <= 0) return redirect()->route("dashboard.admin.income.index")->with("error", "Data Masih Kosong, Tidak Dapat Di export");

        if (!is_null($action)) return $this->excelExport($action);


        $pdf = Pdf::loadView("pages.dashboard.admin.finance.income.export", compact("title", "incomes"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data pendapatan kas" . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
    private function excelExport($action)
    {
        if ($action != "excel") return abort(404);

        return Excel::download(new Income(), "data pendapatan himsi kaliabang.xlsx");
    }
}
