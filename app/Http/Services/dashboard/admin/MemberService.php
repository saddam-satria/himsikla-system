<?php


namespace App\Http\Services\dashboard\admin;

use App\Helpers\StringHelper;
use App\Http\Services\Service;
use App\Repositories\AlumniRepository;
use App\Repositories\MemberRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AbstractMemberService extends Service
{
}


class MemberService extends AbstractMemberService
{
    private  $memberRepository;
    private $userRepository;
    private $alumniRepository;
    public function __construct()
    {
        $this->memberRepository = new MemberRepository();
        $this->userRepository = new UserRepository();
        $this->alumniRepository = new AlumniRepository();
    }
    public function createMember()
    {
        return $this->userRepository->query()->where("isGuest", "=", false)->where("role_id", "!=", 99)->get(["email", "id"]);
    }
    public function insertMember(Request $request, $name, $nim, $phone, $status, $occupation, $user, $address, $token, $division, $periode, $image)
    {

        $validate = array(
            "message" => array(
                "numeric" => "hanya boleh angka",
                "required" => ":attribute tidak boleh kosong",
                "periode.regex" => "format harus benar yyyy-yyyy",
                "phoneNumber.digits_between" => "no handphone harus 11 - 13 angka",
                "unique" => "sudah pernah digunakan",
                "max" => "nama terlalu panjang",
                "image.mimes" => "format file harus sesuai",
                "image.max" => "ukuran file harus 2048kb",

            ),
            "rules" => array(
                "name" => ["required", "max:200"],
                "nim" => ["required", "numeric", "unique:member",],
                "phoneNumber" => ["required", "numeric", "digits_between:11,13", "unique:member"],
                "periode" => ["required", "regex:/(^[\d]{4})-([\d]{4})$/"],
                "address" => ["required"],
                "token" => ["unique:member"],
                "image" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
            )
        );
        $this->validation($request, $validate["rules"], $validate["message"]);

        $data = array(
            "name" => $name,
            "address" => $address,
            "nim" => $nim,
            "status" => $status,
            "phoneNumber" => $phone,
            "occupation" => $this->generateOccupation($occupation, $division),
            "periode" => $periode
        );


        if (!is_null($image)) {
            $profileHash = md5($name . $nim);
            $folderName = public_path("assets/member/profile/" .  $profileHash);
            $fileName = time() . "-profile." . $image->getClientOriginalExtension();

            $image->move($folderName, $fileName);

            $data["image"] =   $profileHash . "/" . $fileName;
        }


        $data = StringHelper::transform("lowercase", $data);
        $data["user_id"] = $user;
        $data["token"] = $token;



        $result = $this->create($this->memberRepository, $data);
        if ($result) return true;


        return false;
    }
    public function updateMember(Request $request, string $id, $name, $nim, $phone, $address,  $periode)
    {
        $updated =  $this->memberRepository->query()->where("id", "=", $id);
        $rules = array(
            "name" => ["required", "max:200"],
            "nim" => ["required", Rule::unique('member')->ignore($updated->first()->id)],
            "phoneNumber" => ["required", "numeric", "digits_between:11,13", Rule::unique('member')->ignore($updated->first()->id)],
            "address" => ["required"],
            "periode" => ["required", "regex:/(^[\d]{4})-([\d]{4})$/"],
        );
        $message = array(
            "required" => ":attribute tidak boleh kosong",
            "numeric" => "isi hanya dengan angka saja",
            "regex" => "format kurang tepat",
            "phoneNumber.digits_between" => "no handphone antara 11 - 13",
            "max" => "nama terlalu panjang",
        );
        $this->validation($request, $rules, $message);

        $updatedMember = array(
            "name" => $name,
            "nim" => $nim,
            "phoneNumber" => $phone,
            "address" => $address,
            "periode" => $periode
        );

        $result = $updated->update($updatedMember);
        if ($result == 1) return true;

        return false;
    }
    public function showMemberByID(string $id)
    {
        return $this->memberRepository->joinUserByMemberID($id)->select("member.image", "member.id", "member.nim", "member.name", "member.phoneNumber", "member.occupation", "member.token", "member.address", "member.periode",  "user.email", "user.gender", "user.university")->first();
    }
    public function deleteMember(Request $request, $id)
    {
        $response = $this->memberRepository->query()->where("id", "=", $id);
        $data = $response->first(array("image", "id"));
        $image = $data->image;
        $folder = public_path("assets/member/profile/");

        if (is_null($data)) return false;

        if (!is_null($image)) {
            if (!File::exists($folder . $image)) return false;
            if (!File::deleteDirectory($folder . explode("/", $image)[0])) return false;
        }


        if ($data->id == auth()->user()->member->id) {
            $request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerateToken();
        }

        return $response->delete();
    }
    public function editMemberByID(string $id)
    {
        return $this->memberRepository->member($id, array("name", "nim", "phoneNumber", "id", "periode", "address"))->first();
    }
    public function editOccupation(string $id)
    {
        return $this->memberRepository->member($id, array("id", "occupation"))->first();
    }
    public function updateOccupation(string $id, $newOccupation)
    {
        $member = $this->memberRepository->query()->where("id", "=", $id);
        $occupation = $this->generateOccupation($newOccupation["occupation"], $newOccupation["division"]);
        $reponse = $member->update(array("occupation" => $occupation));

        if ($reponse == 1) return true;

        return false;
    }
    private function generateOccupation($occupation, $division)
    {
        return str_contains($occupation, "ketua koordinator") || str_contains($occupation, "anggota") ? $occupation . " " . $division : $occupation;
    }
    public function editUser(string $memberID)
    {
        return [
            "users" => $this->userRepository->userNotInMember()->get(["email", "id"]),
            "member" => $this->memberRepository->joinUserByMemberID($memberID)->select("user.email", "member.id")->first()
        ];
    }
    public function updateUser($data, $id)
    {
        $result = $this->update($this->memberRepository, "id", $id, $data);

        if ($result == 1) return true;

        return false;
    }
}
