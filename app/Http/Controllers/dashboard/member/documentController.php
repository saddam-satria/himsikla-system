<?php

namespace App\Http\Controllers\dashboard\member;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class documentController extends Controller
{
    public function index(Request $request)
    {
        $title = "Dokumen";
        $documents = Document::query()->get(array("documentName", "document", "createdAt"));
        return view("pages.dashboard.user.member.document.index", compact("title", "documents"));
    }
    public function download($url)
    {
        $documentPath = public_path() . "/assets/document" . "/";
        $documentURL = str_replace("_", "/", $url);
        $filename = $documentPath . $documentURL;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($filename, explode("/", $documentURL)[1], $headers);
    }
}
