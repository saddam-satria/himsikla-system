<?php

namespace App\Http\Controllers\dashboard\member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class profileController extends Controller
{
    private $memberRepository;
    public function __construct()
    {
        $this->memberRepository = new MemberRepository();
    }
    public function index()
    {
        if (is_null(auth()->user()->member)) return abort(404);

        $title = "dashboard profil anggota";
        return view("pages.dashboard.user.member.index", compact("title"));
    }
    public function division()
    {
        $title = "dashboard divisi anggota";
        $members = $this->memberRepository->query()->where("occupation", "=", auth()->user()->member->occupation)->get(array("image", "name", "nim", "phoneNumber", "occupation", "periode"));
        $division = "rsdm";
        $currentMember = auth()->user()->member->occupation;

        if (str_contains($currentMember, "rsdm")) {
            $division = "rsdm";
        }
        if (str_contains($currentMember, "kominfo")) {
            $division = "kominfo";
        }
        if (str_contains($currentMember, "pendidikan")) {
            $division = "pendidikan";
        }
        if (str_contains($currentMember, "litbang")) {
            $division = "litbang";
        }

        $image = $division . ".png";
        return view("pages.dashboard.user.member.division.index", compact("title", "members", "image"));
    }
    public function edit()
    {
        $title = "edit profile";
        return view("pages.dashboard.user.member.edit", compact("title"));
    }
    public function update(Request $request)
    {
        $rules = array(
            "name" => ["required", "max:200"],
            "nim" => ["required", Rule::unique('member')->ignore(auth()->user()->member->id)],
            "phoneNumber" => ["required", "numeric", "digits_between:11,13", Rule::unique('member')->ignore(auth()->user()->member->id)],
            "address" => ["required"],
            "image" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
        );
        $message = array(
            "required" => ":attribute tidak boleh kosong",
            "numeric" => "isi hanya dengan angka saja",
            "regex" => "format kurang tepat",
            "phoneNumber.digits_between" => "no handphone antara 11 - 13",
            "max" => "nama terlalu panjang",
            "image.mimes" => "format file harus sesuai",
            "image.max" => "ukuran file harus 2048kb",
        );

        $request->validate($rules, $message);

        $data = array(
            "name" => $request->post("name"),
            "nim" => $request->post("nim"),
            "address" => $request->post("address")
        );

        $image = $request->file("image");

        if (!is_null($image)) {

            $folder = public_path("assets/member/profile/");
            $prevImage = auth()->user()->member->image;

            $newFolder = $folder . explode("/", $prevImage)[0];

            if (is_null($prevImage)) {
                $newFolder = $folder . md5(auth()->user()->member->name . auth()->user()->member->nim);
            }


            $fileName = time() . "-member." . $image->getClientOriginalExtension();

            if (!is_null($prevImage)) {
                File::deleteDirectory($folder . explode("/", $prevImage)[0]);
            }


            $image->move($newFolder, $fileName);

            $savedFolder = is_null($prevImage) ?  md5(auth()->user()->member->name . auth()->user()->member->nim) : explode("/", $prevImage)[0];

            $data["image"] = $savedFolder . "/" . $fileName;
        }


        $result = Member::query()->where("id", "=", auth()->user()->member->id)->update($data) == 1;

        if (!$result) return redirect()->route("dashboard.user.member.profile")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.user.member.profile")->with("success", "berhasil di update");
    }
    public function scanner()
    {
        $title = "Scanner QR";


        return view("pages.dashboard.user.member.camera", compact("title"));
    }
}
