<?php

namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\MeetRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MeetService extends Service
{
    private $meetRepository;
    public function __construct()
    {
        $this->meetRepository = new MeetRepository();
    }
    public function insert(Request $request, $name, $material, $startAt, $endAt, $isOnline, $location, $description, $banner, $price, $detailLocation)
    {

        $rules = array(
            "name" => ["required", "max:150"],
            "material" => ["required", "max:200"],
            "startAt" => ["required"],
            "endAt" => ["required"],
            "location" => ["required", "regex:/^https?:\/\//"],
            "banner" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "banner.mimes" => "format file harus sesuai",
            "banner.max" => "ukuran file harus 2048kb",
            "regex" =>  ":attribute format salah"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "meetName" => $name,
            "material" => $material,
            "startAt" => $startAt,
            "endAt" => $endAt,
            "location" => $location,
            "isOnline" => $isOnline == "on",
            "description" => $description,
            "price" => $price,
            "detailLocation" => $detailLocation
        );

        if (!is_null($banner)) {
            $meetHash = md5($name . time());
            $folderName = public_path("assets/banner/" .  $meetHash);
            $fileName = time() . "-banner." . $banner->getClientOriginalExtension();

            $banner->move($folderName, $fileName);
            $data["banner"] =  $meetHash . "/" . $fileName;
        }

        $response = $this->create($this->meetRepository, $data);


        if (!$response) return false;


        return true;
    }
    public function destroyMeet(string $id)
    {
        $response =  $this->meetRepository->query()->where("id", "=", $id);
        $data = $response->first(array("banner"));
        $banner = $data->banner;
        $folder = public_path("assets/banner/");


        if (is_null($data)) return false;

        if (!is_null($banner)) {
            File::deleteDirectory($folder . explode("/", $banner)[0]);
        }

        return $response->delete();
    }
    public function showMeet(string $id)
    {
        return $this->meetRepository->getByMeetID($id);
    }
    public function updateMeet(Request $request, $id, $name, $material, $startAt, $endAt, $isOnline, $location, $description, $banner, $price, $detailLocation)
    {
        $rules = array(
            "name" => ["required", "max:150"],
            "material" => ["required", "max:200"],
            "startAt" => ["required"],
            "endAt" => ["required"],
            "location" => ["required", "regex:/^https?:\/\//"],
            "banner" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "banner.mimes" => "format file harus sesuai",
            "banner.max" => "ukuran file harus 2048kb",
            "regex" =>  ":attribute format salah"
        );

        $this->validation($request, $rules, $messages);

        $data = array(
            "meetName" => $name,
            "material" => $material,
            "startAt" => $startAt,
            "endAt" => $endAt,
            "location" => $location,
            "isOnline" => $isOnline == "on",
            "description" => $description,
            "detailLocation" => $isOnline == "on" ? null : $detailLocation,
            "price" => $price,
        );

        $prevMeet = $this->meetRepository->getByMeetID($id);

        if (!is_null($banner)) {
            $bannerFolder = public_path() . "/assets/banner/";
            $prevBanner = $prevMeet->banner;

            if (!is_null($prevBanner)) {
                File::delete($bannerFolder . $prevBanner);
            };

            $folderName = public_path("assets/banner/" .  explode("/", $prevBanner)[0]);
            $fileName = time() . "-banner." . $banner->getClientOriginalExtension();


            $banner->move($folderName, $fileName);
            $data["banner"] =  explode("/", $prevBanner)[0] . "/" . $fileName;
        }

        $response = $this->meetRepository->updateMeetByID($id, $data);


        if (!$response) return false;


        return true;
    }
    public function finishingMeet($id)
    {
        $response = $this->meetRepository->updateMeetByID($id, array("status" => true));

        return $response == 1;
    }
}
