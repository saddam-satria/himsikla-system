<?php

namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\AlumniRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlumniService extends Service
{
    private $alumniRepository;
    public function __construct()
    {
        $this->alumniRepository = new AlumniRepository();
    }
    public function storeAlumni(Request $request, $name, $periode, $image, $occupation)
    {
        $validate = array(
            "message" => array(
                "numeric" => "hanya boleh angka",
                "required" => ":attribute tidak boleh kosong",
                "periode.regex" => "format harus benar yyyy-yyyy",
                "unique" => "sudah pernah digunakan",
                "max" => "nama terlalu panjang",
                "image.mimes" => "format file harus sesuai",
                "image.max" => "ukuran file harus 2048kb",

            ),
            "rules" => array(
                "name" => ["required", "max:200"],
                "periode" => ["required", "regex:/(^[\d]{4})-([\d]{4})$/"],
                "image" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
            )
        );
        $this->validation($request, $validate["rules"], $validate["message"]);

        $data = array(
            "name" => $name,
            "periode" => $periode,
            "occupation" => $occupation
        );

        if (!is_null($image)) {
            $profileHash = md5($name . time());
            $folderName = public_path("assets/alumni/profiles/" .  $profileHash);
            $fileName = time() . "-profile." . $image->getClientOriginalExtension();

            $image->move($folderName, $fileName);

            $data["image"] =   $profileHash . "/" . $fileName;
        }

        $result = $this->create($this->alumniRepository, $data);


        if (!$result) return false;
        return true;
    }
    public function detailAlumni($id, array $columns = ["*"])
    {
        return $this->alumniRepository->query()->where("id", "=", $id)->first($columns);
    }
    public function updateAlumni(Request $request, $id,  $name, $periode, $image, $occupation)
    {
        $validate = array(
            "message" => array(
                "numeric" => "hanya boleh angka",
                "required" => ":attribute tidak boleh kosong",
                "periode.regex" => "format harus benar yyyy-yyyy",
                "unique" => "sudah pernah digunakan",
                "max" => "nama terlalu panjang",
                "image.mimes" => "format file harus sesuai",
                "image.max" => "ukuran file harus 2048kb",

            ),
            "rules" => array(
                "name" => ["required", "max:200"],
                "periode" => ["required", "regex:/(^[\d]{4})-([\d]{4})$/"],
                "image" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
            )
        );
        $this->validation($request, $validate["rules"], $validate["message"]);

        $data = array(
            "name" => $name,
            "periode" => $periode,
            "occupation" => $occupation
        );

        $prevAlumni = $this->detailAlumni($id, array("image"));

        if (!is_null($image)) {
            $bannerFolder = public_path() . "/assets/banner/";
            $prevProfile = $prevAlumni->image;

            if (!is_null($prevProfile)) {
                File::delete($bannerFolder . $prevProfile);
            };

            $folderName = public_path("assets/alumni/profiles/" .  explode("/", $prevProfile)[0]);
            $fileName = time() . "-profile." . $image->getClientOriginalExtension();

            $image->move($folderName, $fileName);
            $data["image"] =  explode("/", $prevProfile)[0] . "/" . $fileName;
        }

        $response = $this->update($this->alumniRepository, "id", $id, $data) == 1;
        if (!$response) return false;
        return true;
    }
    public function deleteAlumni($id)
    {
        $response = $this->alumniRepository->query()->where("id", "=", $id);
        $data = $response->first(array("image"));
        $image = $data->image;
        $folder = public_path("assets/alumni/profiles/");

        if (!is_null($image)) {
            File::deleteDirectory($folder . explode("/", $image)[0]);
        }


        return $this->alumniRepository->query()->where("id", "=", $id)->delete();
    }
}
