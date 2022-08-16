<?php

namespace App\Http\Controllers\dashboard\member;

use App\DataTables\FinanceDataTable;
use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Repositories\DetailFinanceRepository;
use App\Repositories\FinanceRepository;
use App\Repositories\ReceiptRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class financeController extends Controller
{
    private $detailFinanceRepository;
    private $financeRepository;
    private $receiptRepository;
    public function __construct()
    {
        $this->detailFinanceRepository = new DetailFinanceRepository();
        $this->financeRepository = new FinanceRepository();
        $this->receiptRepository = new ReceiptRepository();
    }
    public function index(FinanceDataTable $financeTable)
    {
        $title = "Keuanganku";
        return $financeTable->render("pages.dashboard.user.member.finance.index", compact("title"));
    }
    public function history()
    {
        $title = "Riwayat Pembayaran Kas";
        $total = DB::table("detail_finance")->where("member_id", "=", auth()->user()->member->id)->sum("cash");
        $paid = DB::table("detail_finance")->whereIn("finance_id", Finance::query()->get(array("id")))->where("status", "=", true)->where("member_id", "=", auth()->user()->member->id)->count();
        $totalOfBill = DB::table("finance")->count();

        $histories = $this->detailFinanceRepository
            ->query()
            ->where("member_id", "=", auth()->user()->member->id)
            ->join("member", "member.id", "=", "detail_finance.member_id")
            ->join("finance", "finance.id", "=", "detail_finance.finance_id")
            ->join("receipt", "receipt.id", "=", "detail_finance.receipt_id")
            ->get(array("finance.month", "receipt.image", "detail_finance.status", "detail_finance.paymentMethod", "detail_finance.createdAt", "detail_finance.cash"));
        return view("pages.dashboard.user.member.finance.history", compact("title", "histories", "total", "paid", "totalOfBill"));
    }
    public function create()
    {
        $title = "Bayar Uang Kas";
        $paymentMethods = array("DANA", "BANK", "OVO", "GOPAY");
        return view("pages.dashboard.user.member.finance.add", compact("title", "paymentMethods"));
    }
    public function payment(Request $request)
    {
        $rules = array(
            "image" => ["required", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"],
            "paymentMethod" => ["required"],
            "cash" => ["required"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong",
            "max" => "Nama Acara Terlalu panjang",
            "image.mimes" => "format file harus sesuai",
            "image.max" => "ukuran file harus 2048kb",
        );

        $request->validate($rules, $messages);

        $finance = $this->financeRepository->query()->where("id", "=", $request->post("finance_id"))->first(array("id", "price"));

        if (is_null($finance)) return redirect()->route("dashboard.member.finance.create")->with("error", "tagihan kas tidak ditemukan");
        if ($request->post("cash") < $finance->price) return redirect()->route("dashboard.member.finance.create")->with("error", "Duitnya masih kurang");

        $detailFinance = $this->detailFinanceRepository->query()->where("finance_id", "=", $finance->id)->where("member_id", "=", auth()->user()->member->id)->first(array("id"));

        if (!is_null($detailFinance)) return redirect()->route("dashboard.member.finance.history")->with("error", "uang kas sudah dibayar");


        $data = array(
            "member_id" => auth()->user()->member->id,
            "finance_id" => $finance->id,
            "paymentMethod" => $request->post("paymentMethod"),
            "cash" => $request->post("cash"),
        );

        $receipt = $request->file("image");

        $receiptHash = md5(auth()->user()->member->id);
        $folderName = public_path("assets/bukti-pembayaran/" .  $receiptHash);
        $fileName = time() . "-bukti." . $receipt->getClientOriginalExtension();

        $receipt->move($folderName, $fileName);

        $id = Uuid::uuid4();
        $this->receiptRepository->query()->create(array("image" => $receiptHash . "/" . $fileName, "id" => $id));
        $data["receipt_id"] = $id;

        $result = $this->detailFinanceRepository->query()->create($data);

        if (!$result) return redirect()->route("dashboard.member.finance.history")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.member.finance.history")->with("success", "pembayaran sukses");
    }
    public function export()
    {
        $title = "Data Riwayat Pembayaran Kas " .  strtoupper(auth()->user()->member->name);
        $members = $this->detailFinanceRepository
            ->query()
            ->where("member_id", "=", auth()->user()->member->id)
            ->join("member", "member.id", "=", "detail_finance.member_id")
            ->join("finance", "finance.id", "=", "detail_finance.finance_id")
            ->get(array("finance.month", "detail_finance.status", "detail_finance.paymentMethod", "detail_finance.createdAt", "detail_finance.cash"));

        if (count($members) < 1) return redirect()->route("dashboard.member.finance.history")->with("error", "Data Masih Belum Ada, Tidak Dapat Di Export");

        $pdf = Pdf::loadView("pages.dashboard.user.member.finance.export", compact("title", "members"))->setPaper("A4", "potrait")->setOption(array('dpi' => 150, 'defaultFont' => 'sans-serif'));
        return $pdf->download("history pembayaran kas " . auth()->user()->member->name . "-" . date_format(date_create("now"), "d-m-Y h:i:s"));
    }
}
