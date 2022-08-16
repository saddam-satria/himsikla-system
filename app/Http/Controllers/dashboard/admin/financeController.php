<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\DetailFinanceDataTable;
use App\DataTables\FinanceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\FinancialService;
use App\Models\DetailFinance;
use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class financeController extends Controller
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
    public function index(FinanceDataTable $financeTable)
    {
        $title = "Data Tagihan Kas";
        return $financeTable->render("pages.dashboard.admin.finance.index", compact("title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Kas";
        return view("pages.dashboard.admin.finance.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->financialService->storeFinance($request, $request->post("month"), $request->post("price"), $request->post("description"), $request->post("payment"), $request->post("penalty"));

        if (!$result) return redirect()->route("dashboard.admin.finance.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.index")->with("success", "sukses menambahkan data kas");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, DetailFinanceDataTable $detailFinanceTable)
    {
        $title = "Detail Pembayaran Kas";
        $month = $this->financialService->finance($id, array("month"));
        $total = DB::table("detail_finance")->selectRaw("sum(cash) as cash , count(member_id) as total_member")->join("member", "member.id", "=", "detail_finance.member_id")->where("finance_id", "=", $id)->first();
        $member = DB::table("member")->count();
        $member = $member - $total->total_member;
        return $detailFinanceTable->with("id", $id)->render("pages.dashboard.admin.finance.detail", compact("title", "month", "total", "member", "id"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Kas";
        $finance = $this->financialService->finance($id, array("id", "payment", "month", "price", "description"));
        if (is_null($finance)) return abort(404);
        return view("pages.dashboard.admin.finance.edit", compact("title", "finance"));
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
        $result = $this->financialService->updateFinance($request, $id, $request->post("month"), $request->post("price"), $request->post("description"), $request->post("payment"), $request->post("penalty"));
        if (!$result) return redirect()->route("dashboard.admin.finance.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.index")->with("success", "sukses mengupdate data kas");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->financialService->deleteFinance($id);
        if (!$result) return redirect()->route("dashboard.admin.finance.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.index")->with("success", "sukses menghapus data kas");
    }
    public function export($finance)
    {

        $financeByID = Finance::query()->where("id", "=", $finance)->first(array("id", "month"));

        if (is_null($financeByID)) return abort(404);

        $title = " Data Pembayaran Kas " . $financeByID->id;

        $members = DetailFinance::query()
            ->where("detail_finance.finance_id", "=", $finance)
            ->join("member", "member.id", "=", "detail_finance.member_id")
            ->join("finance", "finance.id", "=", "detail_finance.finance_id")
            ->get(array("finance.month", "detail_finance.status", "detail_finance.paymentMethod", "detail_finance.createdAt", "detail_finance.cash", "member.name", "member.nim"));

        if (count($members) <= 0) return redirect()->route("dashboard.admin.finance.show", $financeByID->id)->with("error", "Data Masih Kosong, Tidak Dapat Di export");

        $pdf = Pdf::loadView("pages.dashboard.admin.finance.export", compact("title", "members"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("data pembayaran kas " . $financeByID->month . "-himsi-kaliabang" . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
}
