<?php


namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\BalanceSheetRepository;
use App\Repositories\DetailFinanceRepository;
use App\Repositories\FinanceRepository;
use App\Repositories\IncomeRepository;
use App\Repositories\MemberRepository;
use App\Repositories\OutcomeRepository;
use App\Repositories\ReceiptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;

class FinancialService extends Service
{
    private $financeRepository;
    private $incomeRepository;
    private $outcomeRepository;
    private $balanceSheetRepository;
    private $detailFinanceRepository;
    private $memberRepository;
    private $receiptRepository;
    public $months = array("JANUARI", "FEBUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
    public function __construct()
    {
        $this->financeRepository = new FinanceRepository();
        $this->incomeRepository = new IncomeRepository();
        $this->outcomeRepository = new OutcomeRepository();
        $this->balanceSheetRepository = new BalanceSheetRepository();
        $this->detailFinanceRepository = new DetailFinanceRepository();
        $this->memberRepository = new MemberRepository();
        $this->receiptRepository = new ReceiptRepository();
    }
    public function incomes(array $columns = ["*"])
    {
        return $this->incomeRepository->query()->get($columns);
    }
    public function outcomes(array $columns = ["*"])
    {
        return $this->outcomeRepository->query()->get($columns);
    }
    public function finances(array $columns = ["*"])
    {
        return $this->financeRepository->query()->get($columns);
    }
    public function finance(string $id, array $columns =  ["*"])
    {
        return $this->financeRepository->query()->where("id", "=", $id)->first($columns);
    }
    public function detailFinances(array $columns = ["*"])
    {
        return $this->detailFinanceRepository->query()->get($columns);
    }
    public function detailFinance($id, array $columns = ["*"])
    {
        return $this->detailFinanceRepository
            ->query()
            ->where("detail_finance.id", "=", $id)
            ->join("member", "member.id", "=", "detail_finance.member_id")
            ->join("receipt", "receipt.id", "=", "detail_finance.receipt_id")
            ->join("finance", "finance.id", "=", "detail_finance.finance_id")
            ->first($columns);
    }
    public function members(array $columns = ["*"])
    {
        return $this->memberRepository->query()->get($columns);
    }
    public function storeFinance(Request $request, $month, $price, $description, $payment, $penalty)
    {
        $rules = array(
            "month" => ["required"],
            "price" => ["required"],
            "payment" => ["required"],
            "description" => ["nullable"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "month" => $month,
            "price" => $price,
            "description" => $description,
            "payment" => $payment,
            "penalty" => $penalty
        );

        $response = $this->create($this->financeRepository, $data);

        if (!$response) return false;

        return true;
    }
    public function updateFinance(Request $request, $id, $month, $price, $description, $payment, $penalty)
    {
        $rules = array(
            "month" => ["required"],
            "price" => ["required"],
            "payment" => ["required"],
            "description" => ["nullable"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);
        $data = array(
            "month" => $month,
            "price" => $price,
            "description" => $description,
            "payment" => $payment,
            "penalty" => $penalty
        );
        return $this->financeRepository->query()->where("id", "=", $id)->update($data) == 1;
    }
    public function deleteFinance($id)
    {
        return $this->financeRepository->query()->where("id", "=", $id)->delete();
    }
    public function income($id, array $columns = ["*"])
    {
        return $this->incomeRepository->query()->where("id", "=", $id)->first($columns);
    }
    public function storeIncome($isIncome = true, Request $request, $date, $total, $description)
    {
        $rules = array(
            "date" => ["required", "date"],
            "total" => ["required"],
            "description" => ["nullable"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);
        $data = array(
            "date" => $date,
            "total" => $total,
            "description" => $description,

        );

        if (!$isIncome) {
            $response =  $this->outcomeRepository->query()->create($data);
            if (!$response) return false;
            return true;
        }


        $response =  $this->incomeRepository->query()->create($data);

        if (!$response) return false;


        return true;
    }
    public function deleteIncome($isIncome  = true, $id)
    {
        if (!$isIncome) return $this->outcomeRepository->query()->where("id", "=", $id)->delete();
        return $this->incomeRepository->query()->where("id", "=", $id)->delete();
    }
    public function updateIncome($isIncome = true, Request $request, $id, $date, $total, $description)
    {
        $rules = array(
            "date" => ["required", "date"],
            "total" => ["required"],
            "description" => ["nullable"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);
        $data = array(
            "date" => $date,
            "total" => $total,
            "description" => $description,

        );
        if (!$isIncome) return $this->outcomeRepository->query()->where("id", "=", $id)->update($data) == 1;
        return $this->incomeRepository->query()->where("id", "=", $id)->update($data) == 1;
    }
    public function outcome($id, array $columns = ["*"])
    {
        return $this->outcomeRepository->query()->where("id", "=", $id)->first($columns);
    }
    public function storeOutcome(Request $request, $date, $total, $description)
    {
        return $this->storeIncome(false, $request, $date, $total, $description);
    }
    public function deleteOutcome($id)
    {
        return $this->deleteIncome(false, $id);
    }
    public function updateOutcome(Request $request, $id, $date, $total, $description)
    {
        return $this->updateIncome(false, $request, $id, $date, $total, $description);
    }
    public function balance($id, array $columns = ["*"])
    {
        return $this->balanceSheetRepository->query()->where("id", "=", $id)->first($columns);
    }
    public function storeBalanceSheet(Request $request, $month, $debit, $kredit, $note)
    {
        $rules = array(
            "debit" => ["nullable"],
            "kredit" => ["nullable"],
            "note" => ["nullable"]
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "month" => $month,
            "debit" => $debit,
            "kredit" => $kredit,
            "note" => $note
        );

        $response = $this->create($this->balanceSheetRepository, $data);
        if (!$response) return false;


        return true;
    }
    public function updateBalanceSheet(Request $request, $id, $month, $debit, $kredit, $note)
    {

        $rules = array(
            "debit" => ["nullable"],
            "kredit" => ["nullable"],
            "note" => ["nullable"]
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "month" => $month,
            "debit" => $debit,
            "kredit" => $kredit,
            "note" => $note
        );

        return $this->update($this->balanceSheetRepository, "id", $id,  $data) == 1;
    }
    public function deleteBalanceSheet($id)
    {
        return $this->balanceSheetRepository->query()->where("id", "=", $id)->delete();
    }
    public function storeDetailFinance(Request $request, $member_id, $finance_id, $receipt, $paymentMethod, $cash, $status)
    {

        $rules = array(
            "member_id" => ["required"],
            "finance_id" => ["required"],
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

        $this->validation($request, $rules, $messages);
        $data = array(
            "member_id" => $member_id,
            "finance_id" => $finance_id,
            "paymentMethod" => $paymentMethod,
            "status" => $status,
            "cash" => $cash
        );


        $receiptHash = md5($member_id);
        $folderName = public_path("assets/bukti-pembayaran/" .  $receiptHash);
        $fileName = time() . "-bukti." . $receipt->getClientOriginalExtension();

        $receipt->move($folderName, $fileName);

        $id = Uuid::uuid4();
        $this->receiptRepository->query()->create(array("image" => $receiptHash . "/" . $fileName, "id" => $id));

        $data["receipt_id"] = $id;


        $response = $this->detailFinanceRepository->query()->create($data);
        if (!$response) return false;

        return true;
    }
    public function deleteDetailFinance($id)
    {
        $response =  $this->detailFinanceRepository->query()->where("id", "=", $id);
        $receipt = $response->first(array("receipt_id"));
        $receipt_id = $receipt->receipt_id;

        $dataReceipt = $this->receiptRepository->query()->where("id", "=", $receipt_id)->first(array("image"));
        $image = $dataReceipt->image;
        $folder = public_path("assets/bukti-pembayaran/");

        File::deleteDirectory($folder . explode("/", $image)[0]);

        return $response->delete();
    }
    public function updateDetailFinance(Request $request, $id,  $paymentMethod, $cash,  $status)
    {
        $rules = array(
            "paymentMethod" => ["required"],
            "cash" => ["required"],
            "penalty" => ["nullable"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong",
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "paymentMethod" => $paymentMethod,
            "status" => $status,
            "cash" => $cash
        );

        return $this->detailFinanceRepository->query()->where("id", "=", $id)->update($data) == 1;
    }
    public function updateReceipt(Request $request, $id, $receipt)
    {
        $rules = array(
            "image" => ["required", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"],
        );
        $messages  = array(
            "required" => ":attribute tidak boleh kosong",
            "image.mimes" => "format file harus sesuai",
            "image.max" => "ukuran file harus 2048kb",
        );

        $this->validation($request, $rules, $messages);

        $folder = public_path("assets/bukti-pembayaran/");
        $response =  $this->detailFinanceRepository->query()->where("id", "=", $id);
        $receiptRaw = $response->first(array("receipt_id"));
        $receipt_id = $receiptRaw->receipt_id;
        $dataReceipt = $this->receiptRepository->query()->where("id", "=", $receipt_id)->first(array("image"));
        $prevReceipt = $dataReceipt->image;
        $newFolder = $folder . explode("/", $prevReceipt)[0];
        $fileName = time() . "-bukti." . $receipt->getClientOriginalExtension();

        File::deleteDirectory($folder . explode("/", $prevReceipt)[0]);

        $receipt->move($newFolder, $fileName);
        return $this->receiptRepository->query()->where("id", "=", $receipt_id)->update(array(
            "image" => explode("/", $prevReceipt)[0] . "/" . $fileName
        )) == 1;
    }
    public function confirmationPayment($id)
    {
        return $this->detailFinanceRepository->query()->where("id", "=", $id)->update(array("status" => true)) == 1;
    }
}
