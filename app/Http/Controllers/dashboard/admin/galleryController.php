<?php

namespace App\Http\Controllers\dashboard\admin;

use App\Http\Controllers\Controller;
use App\Models\gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class galleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "data foto";
        $galleries = gallery::query()->get(array("image", "id"));
        return view("pages.dashboard.admin.gallery.index", compact("title", "galleries"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "tambah foto";
        return view("pages.dashboard.admin.gallery.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array("image" => ["required", "mimes:jpeg,png,jpg,JPG,PNG,JPEG", "max:2048"]);
        $messages = array(
            "image.mimes" => "format file harus sesuai",
            "image.max" => "ukuran file harus 2048kb",
        );
        $request->validate($rules, $messages);

        $image = $request->file("image");

        $folderName = public_path("assets/gallery/");
        $fileName = md5(time()) . "-image." . $image->getClientOriginalExtension();

        $image->move($folderName, $fileName);

        $data = array(
            "image" => $fileName
        );
        $result = gallery::query()->create($data);

        if (!$result) return redirect()->route("dashboard.admin.gallery.index")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.gallery.index")->with("success", "Berhasil Menambahkan Foto Baru");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = gallery::query()->where("id", "=", $id);

        $image = $gallery->first(array("image"))->image;
        $path = public_path("assets/gallery" . "/" . $image);

        if (File::exists($path)) {
            File::delete($path);
        }


        if (!$gallery->delete()) return redirect()->route("dashboard.admin.gallery.index")->with("error", "Terjadi Kesalahan");
        return redirect()->route("dashboard.admin.gallery.index")->with("success", "Berhasil Menghapus Foto");
    }
}
