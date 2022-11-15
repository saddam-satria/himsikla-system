<?php


namespace App\Http\Services\dashboard\admin;

use App\Http\Services\Service;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class DocumentService extends Service
{
    private $documentRepository;
    public function __construct()
    {
        $this->documentRepository = new DocumentRepository();
    }
    public function documents(array $columns = ["*"])
    {
        return $this->documentRepository->query()->get($columns);
    }
    public function storeDocument(Request $request, $documentName, $documentFile)
    {

        $rules = array(
            "name" => ["required", "max:150"],
            "document" => ["required", "mimes:pdf", "max:10000"]
        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "mimes" => "format harus PDF",
            "document.max" => "ukuran file harus kurang dari 10mb",
            "name.max" => "nama dokumen terlalu panjang"
        );

        $this->validation($request, $rules, $messages);

        $documentHash = md5($documentName);
        $folderName = public_path("assets/document/" .  $documentHash);
        $fileName = time() . "-document." . $documentFile->getClientOriginalExtension();

        $documentFile->move($folderName, $fileName);

        $data = array(
            "document" => $documentHash . "/" . $fileName,
            "documentName" => $documentName
        );
        $response = $this->documentRepository->query()->create($data);
        if (!$response) return false;

        return true;
    }
    public function detailDocument($id, array $columns = ["*"])
    {
        return $this->documentRepository->documentByID($id, $columns);
    }
    public function updateDocument(Request $request, $id, $documentName)
    {
        $rules = array(
            "name" => ["required", "max:150"],

        );

        $messages = array(
            "required" => ":attribute tidak boleh kosong",
            "name.max" => "nama dokumen terlalu panjang"
        );

        $this->validation($request, $rules, $messages);
        return $this->documentRepository->query()->where("id", "=", $id)->update(array("documentName" => $documentName)) == 1;
    }
    public function documentPreview($id)
    {
        $document = $this->documentRepository->documentByID($id, array("document"));
        $folder = public_path("assets/document/");
        $docFile = $folder . $document->document;

        if (is_null($document)) return false;
        if (!File::exists($docFile)) return false;



        return response()->file($docFile, array('Content-Type' => 'application/pdf'));
    }
    public function deleteDocument($id)
    {
        $data = $this->documentRepository->query()->where("id", "=", $id);
        $document = $data->first(array("document"));
        $folder = public_path("assets/document/");


        if (is_null($document)) return false;
        File::deleteDirectory($folder . explode("/", $document->document)[0]);



        return $data->delete();
    }
}
