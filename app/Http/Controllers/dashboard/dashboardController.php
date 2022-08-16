<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\DetailFinance;
use App\Models\Document;
use App\Models\Income;
use App\Repositories\EventRepository;
use App\Repositories\MeetRepository;
use App\Repositories\MemberRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    private $eventRepository;
    private $meetRepository;
    private $memberRepository;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->meetRepository = new MeetRepository();
        $this->memberRepository = new MemberRepository();
    }

    public function index()
    {

        $currentMonth = date("Y-m");
        $title = "Dashboard";
        $event  = DB::table("event")->count();
        $meet = DB::table("meet")->count();
        $member = DB::table("member")->count();
        $document = DB::table("document")->count();
        $documents = Document::query()->get(array("documentName", "document"))->take(5);

        $balanceSheets = DB::table("balance_sheet")->select([DB::raw("SUM(debit) as debit"), DB::raw("SUM(kredit) as kredit"), DB::raw("SUM(debit - kredit) AS total"), "month"])
            ->groupBy("month")->get();

        $members = $this->memberRepository->query()->orderBy("createdAt", "DESC")->get(array("image", "name", "occupation"))->take(5);
        $alumnis = DB::table("alumni")->select(array(DB::raw("count(*) AS total_alumni , periode")))->groupBy("periode")->get();

        $meets = $this->meetRepository->query()->orderBy("createdAt", "ASC")->take(5)->get(array("banner", "meetName"));
        $income = DB::table("income")->selectRaw("SUM(total) as total")->whereMonth("date", Carbon::now()->month)->first();
        $outcome = DB::table("outcome")->selectRaw("SUM(total) as total")->whereMonth("date", Carbon::now()->month)->first();

        $memberPaid = DB::table("detail_finance")->selectRaw("count(detail_finance.member_id) AS total_member")->join("finance", "finance.id", "=", "detail_finance.finance_id")->where("finance.month", "=", $currentMonth)->groupBy("finance.month")->first();

        $histories = DetailFinance::query()->orderBy("detail_finance.createdAt", "DESC")->join("finance", "finance.id", "=", "detail_finance.finance_id")->where("member_id", "=", auth()->user()->member->id)->take(5)->get(array("finance.month", "detail_finance.cash", "detail_finance.paymentMethod", "detail_finance.status"));

        $totalPayment = DB::table("detail_finance")->where("member_id", "=", auth()->user()->member->id)->sum("cash");
        $totalPaidBill = DB::table("detail_finance")->where("member_id", "=", auth()->user()->member->id)->where("status", "=", true)->count();
        $notPaid = DB::table("finance")->count() - $totalPaidBill;

        return view("pages.dashboard.index", compact("title", "event", "meet", "member", "document", "balanceSheets", "members", "alumnis", "income", "outcome", "memberPaid", "meets", "totalPayment", "notPaid", "histories", "totalPaidBill", "documents"));
    }
}
