<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\BalanceSheetDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\FinancialService;
use App\Models\BalanceSheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class balanceSheetController extends Controller
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
    public function index(Request $request, BalanceSheetDataTable $balanceSheetTable)
    {
        $title = "Data Neraca";
        $months = $this->financialService->months;
        $filter = $request->get("filter");
        return $balanceSheetTable->with("filter", $filter)->render("pages.dashboard.admin.finance.balance_sheet.index", compact("title", "months", "filter"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Data Neraca";
        $incomes = $this->financialService->incomes(array("date", "description", "total"));
        $outcomes = $this->financialService->outcomes(array("date", "description", "total"));
        $months = $this->financialService->months;
        return view("pages.dashboard.admin.finance.balance_sheet.add", compact("title", "incomes", "outcomes", "months"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->financialService->storeBalanceSheet($request, $request->post("month"), $request->post("debit"), $request->post("kredit"), $request->post("note"));

        if (!$result) return redirect()->route("dashboard.admin.balance_sheet.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.balance_sheet.index")->with("success", "berhasil menambahkan data neraca");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Neraca";
        $balance = $this->financialService->balance($id, array("debit", "kredit", "id", "note", "month"));
        if (is_null($balance)) return abort(404);
        return view("pages.dashboard.admin.finance.balance_sheet.detail", compact("title", "balance"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Data Neraca";
        $incomes = $this->financialService->incomes(array("date", "description", "total"));
        $outcomes = $this->financialService->outcomes(array("date", "description", "total"));
        $months = $this->financialService->months;
        $balance = $this->financialService->balance($id, array("debit", "kredit", "id", "note", "month"));
        if (is_null($balance)) return abort(404);
        return view("pages.dashboard.admin.finance.balance_sheet.edit", compact("title", "incomes", "outcomes", "months", "balance"));
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
        $result = $this->financialService->updateBalanceSheet($request, $id, $request->post("month"), $request->post("debit"), $request->post("kredit"), $request->post("note"));
        if (!$result) return redirect()->route("dashboard.admin.balance_sheet.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.balance_sheet.index")->with("success", "berhasil mengupdate data neraca");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->financialService->deleteBalanceSheet($id);
        if (!$result) return redirect()->route("dashboard.admin.balance_sheet.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.balance_sheet.index")->with("success", "berhasil menghapus data neraca");
    }
    public function export(Request $request)
    {
        $balanceSheets = BalanceSheet::query()->get(array("month", "note", "debit", "kredit"));

        $filter = $request->get("filter");
        $title = "Data Neraca";

        if (!is_null($filter)) {
            $balanceSheets =  BalanceSheet::Where("month", "=", $filter)
                ->select([DB::raw("SUM(debit) as debit"), DB::raw("SUM(kredit) as kredit"), DB::raw("SUM(debit - kredit) AS total"), "month"])
                ->groupBy("month")
                ->get();

            $title = "Data Neraca Bulan " . $filter;
        }

        if (count($balanceSheets) <= 0) return redirect()->route("dashboard.admin.balance_sheet.index")->with("error", "Data Masih Kosong, Tidak Dapat Di export");

        $pdf = Pdf::loadView("pages.dashboard.admin.finance.balance_sheet.export", compact("title", "balanceSheets", "filter"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data neraca kas" . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
}
