<?php

namespace App\Http\Controllers\dashboard\admin;

use App\Http\Controllers\Controller;
use App\Http\Services\dashboard\admin\FinancialService;
use Illuminate\Http\Request;

class detailFinanceController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Pembayaran Kas";
        $paymentMethods = array("DANA", "BANK", "OVO", "GOPAY");
        $finances = $this->financialService->finances(array("id", "month", "price"));
        $members = $this->financialService->members(array("id", "name", "nim"));
        return view("pages.dashboard.admin.finance.detail.add", compact("title", "paymentMethods", "finances", "members"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->financialService->storeDetailFinance($request, $request->post("member_id"), $request->post("finance_id"), $request->file("image"), $request->post("paymentMethod"), $request->post("cash"), $request->post("status") == 1);
        if (!$result) return redirect()->route("dashboard.admin.finance.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.index")->with("success", "sukses menambahkan pembayaran baru");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Pembayaran";
        $finance = $this->financialService->detailFinance($id, array("member.name", "member.nim", "member.phoneNumber", "detail_finance.createdAt", "detail_finance.paymentMethod", "detail_finance.status", "finance.penalty", "detail_finance.cash", "detail_finance.id", "receipt.image", "finance.price", "finance.month", "finance.payment", "finance.id as finance_id"));
        if (is_null($finance)) return abort(404);
        return view("pages.dashboard.admin.finance.detail.show", compact("title", "finance"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        if ($request->get("edit") && $request->get("edit") == "receipt") return $this->editReceipt($request, $id);
        $title = "Update Pembayaran Kas";
        $paymentMethods = array("DANA", "BANK", "OVO", "GOPAY");
        $finance = $this->financialService->detailFinance($id, array("receipt.image", "detail_finance.cash",  "detail_finance.id", "member.name", "finance.id AS finance_id"));
        if (is_null($finance)) return abort(404);
        return view("pages.dashboard.admin.finance.detail.edit", compact("title", "paymentMethods",  "finance", "id"));
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
        if ($request->get("edit") && $request->get("edit") == "receipt") return $this->updateReceipt($request, $id);
        if ($request->get("action") && $request->get("action") == "confirmation") return $this->confirmationPayment($id);

        $result = $this->financialService->updateDetailFinance($request, $id, $request->post("paymentMethod"), $request->post("cash"), $request->post("status") == 1);
        $finance = $this->financialService->detailFinance($id, array("detail_finance.finance_id"));
        if (!$result) return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("success", "sukses mengupdate detail pembayaran");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $finance = $this->financialService->detailFinance($id, array("detail_finance.finance_id"));
        $result = $this->financialService->deleteDetailFinance($id);
        if (!$result) return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("success", "Sukses Menghapus Detail Pembayaran");
    }
    private function editReceipt(Request $request, $id)
    {
        $title = "Edit Bukti Pembayaran";
        $finance = $this->financialService->detailFinance($id, array("receipt.image", "detail_finance.id"));
        if (is_null($finance)) return abort(404);
        return view("pages.dashboard.admin.finance.detail.edit_image", compact("title", "finance"));
    }
    private function updateReceipt(Request $request, $id)
    {
        $result = $this->financialService->updateReceipt($request, $id, $request->file("image"));
        $finance = $this->financialService->detailFinance($id, array("detail_finance.finance_id"));
        if (!$result) return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("success", "sukses mengupdate bukti pembayaran");
    }
    private function confirmationPayment($id)
    {
        $result = $this->financialService->confirmationPayment($id);
        $finance = $this->financialService->detailFinance($id, array("detail_finance.finance_id"));
        if (!$result) return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.finance.show", $finance->finance_id)->with("success", "sukses konfirmasi pembayaran");
    }
}
