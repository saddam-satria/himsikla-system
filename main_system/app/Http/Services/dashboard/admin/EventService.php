<?php


namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Models\Certificate;
use App\Repositories\EventRepository;
use App\Repositories\MemberRepository;
use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class EventService extends Service
{
    private $eventRepository;
    private $memberRepository;
    private $certificateRepository;
    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->memberRepository = new MemberRepository();
        $this->certificateRepository = new CertificateRepository();
    }
    public function insert(Request $request, $eventName, $startAt, $endAt, $description, $isGeneral, $isFree, $price, $isOnline, $location, $banner, $detailLocation, $feedback, $payment, $contact)
    {

        $rules = array(
            "name" => ["required", "max:150"],
            "startAt" => ["required"],
            "endAt" => ["required"],
            "price" => [Rule::requiredIf($isFree == 1)],
            "location" => ["required", "regex:/^https?:\/\//"],
            "feedback" => ["nullable", "regex:/^https?:\/\//"],
            "description" => ["required"],
            "banner" => ["nullable", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]
        );
        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "max" => "Nama Acara Terlalu panjang",
            "banner.mimes" => "format file harus sesuai",
            "banner.max" => "ukuran file harus 2048kb",
            "regex" =>  ":attribute format salah"

        );
        $this->validation($request, $rules, $messages);

        $data = array(
            "eventName" => $eventName,
            "startAt" => $startAt,
            "endAt" => $endAt,
            "description" => $description,
            "price" => $price,
            "isGeneral" => $isGeneral == 1 ? true : false,
            "isOnline" => $isOnline == "on" ? true : false,
            "location" => $location,
            "member_id" => isset(auth()->user()->id) ? $this->memberRepository->query()->where("user_id", "=", auth()->user()->id)->first(["id"])["id"] : null,
            "detailLocation" => $detailLocation,
            "feedback" => $feedback,
            "payment" => $payment,
            "contactPerson" => $contact
        );

        if (!is_null($banner)) {
            $eventHash = md5($eventName . time());
            $folderName = public_path("assets/banner/" .  $eventHash);
            $fileName = time() . "-banner." . $banner->getClientOriginalExtension();

            $banner->move($folderName, $fileName);

            $data["banner"] =   $eventHash . "/" . $fileName;
        }

        $response = $this->create($this->eventRepository, $data);

        if (!$response) return false;


        return true;
    }
    public function showEventByID(string $id)
    {

        return array(
            "event" => $this->eventRepository->getEventByID($id),
            "certificate" => $this->certificateRepository->certificateByEventID($id, array("certificate.link"))
        );
    }
    public function updateEventByID(Request $request, string $id, $eventName, $startAt, $endAt, $description, $price, $isGeneral, $isOnline, $location, $isFree, $detailLocation, $feedback, $payment, $contact)
    {
        $rules = array(
            "name" => ["required", "max:150"],
            "startAt" => ["required"],
            "endAt" => ["required"],
            "price" => [Rule::requiredIf($isFree == 1)],
            "location" => ["required", "regex:/^https?:\/\//"],
            "feedback" => ["nullable", "regex:/^https?:\/\//"],
            "description" => ["required"],
        );
        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "max" => "Nama Acara Terlalu panjang",
            "regex" =>  ":attribute format salah"
        );
        $this->validation($request, $rules, $messages);

        $response = $this->eventRepository->getEventByID($id)->update(
            array(
                "eventName" => $eventName,
                "startAt" => $startAt,
                "endAt" => $endAt,
                "description" => $description,
                "price" => $price,
                "isGeneral" => $isGeneral == 1 ? true : false,
                "isOnline" => $isOnline == "on" ? true : false,
                "location" => $location,
                "detailLocation" => $isOnline == "on" ? null : $detailLocation,
                "feedback" => $feedback,
                "payment" => $payment,
                "contactPerson" => $contact
            )
        );


        return $response == 1;
    }
    public function deleteEventByID(string $id)
    {
        $response =  $this->eventRepository->getEventByID($id);
        $data = $response->first(array("banner"));
        $banner = $data->banner;
        $folder = public_path("assets/banner/");
        $bannerFile = $folder . $banner;


        if (is_null($data)) return false;

        if (!is_null($banner)) {
            if (!File::exists($bannerFile)) return false;
            File::deleteDirectory($folder . explode("/", $banner)[0]);
        }


        return $response->delete();
    }
    public function events(array $columns = ["*"])
    {
        return $this->eventRepository->query()->where("status", "=", true)->get($columns);
    }
    public function storeCertificate(Request $request, $link, $event_id)
    {
        $rules = array(
            "link" => ["required", "regex:/^https?:\/\//"],
            "event_id" => ["required"]
        );

        $messages  = array(
            "required" => ":attribute Tidak Boleh Kosong",
            "regex" =>  ":attribute format salah"
        );

        $request->validate($rules, $messages);

        $data = array(
            "link" => $link,
            "event_id" => $event_id
        );

        $response = $this->create(Certificate::query(), $data);

        if (!$response) return false;

        return true;
    }
    public function editBanner($id)
    {

        return $this->eventRepository->getEventByID($id)->get(["banner", "id"])->first();
    }
    public function updateBanner(Request $request, $id, $newBanner)
    {
        $rules = array(
            "banner" => ["required", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]

        );
        $messages = array(
            "mimes" => ":attribute format file harus sesuai",
            "max" => ":attribute ukuran file harus 2048kb"
        );
        $this->validation($request, $rules, $messages);



        $folder = public_path("assets/banner/");
        $event = $this->eventRepository->getEventByID($id);
        $prevBanner = $event->get(["banner"])->first()->banner;

        $newFolder = $folder . explode("/", $prevBanner)[0];
        $fileName = time() . "-banner." . $newBanner->getClientOriginalExtension();

        if (!is_null($prevBanner)) {
            File::deleteDirectory($folder . explode("/", $prevBanner)[0]);
        }


        $newBanner->move($newFolder, $fileName);

        $response = $event->update(array(
            "banner" => explode("/", $prevBanner)[0] . "/" . $fileName
        ));

        if ($response == 1) return true;
        return false;
    }
    public function editCertificate(string $id)
    {
        return $this->certificateRepository->query()->where("id", "=", $id);
    }
    public function updateCertificate(Request $request, string $id, array $data, $type = "link")
    {
        $rules = array(
            "link" =>  ["required", "regex:/^https?:\/\//"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "regex" =>  ":attribute format salah"
        );
        if ($type != "link") {
            $rules = array(
                "event_id" => ["required"]
            );

            $messages = array(
                "required" => ":attribute tidak boleh kosong"
            );
        }


        $this->validation($request, $rules, $messages);

        $certificate = $this->certificateRepository->certificateByID($id);
        $response = $certificate->update($data);

        if ($response == 1) return true;


        return false;
    }
    public function destroyCertificate(string $id)
    {
        $response = $this->certificateRepository->certificateByID($id)->delete();

        if (!$response) return false;


        return true;
    }
    public function finishingEvent($id)
    {
        $response = $this->eventRepository->getEventByID($id)->update(
            array(
                "status" => true
            )
        );

        return $response == 1;
    }
}
