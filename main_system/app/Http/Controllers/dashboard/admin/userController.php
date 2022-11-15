<?php

namespace App\Http\Controllers\dashboard\admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Services\auth\ResetPasswordService;
use App\Http\Services\dashboard\admin\UserService;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class userController extends Controller
{

    private $userService;
    private $resetPasswordService;
    public function __construct()
    {
        $this->userService = new UserService(new UserRepository());
        $this->resetPasswordService = new ResetPasswordService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $userTable)
    {
        $title = "Data Akun";
        $contents = array("dashboard", "admin", "user");
        return $userTable->render("pages.dashboard.admin.user.index", compact("title", "contents"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Akun";
        $contents = ["dashboard", "admin", "user", "tambah"];
        $gender = ["laki-laki", "perempuan"];
        return view("pages.dashboard.admin.user.add", compact("title", "contents", "gender"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = $this->userService->insert($request, $request->post("email"), $request->post("password"), $request->post("isGuest"), $request->post("gender"),  $request->post("university"));
        if ($result) return redirect()->route("dashboard.admin.user.index")->with("success", "berhasil menambahkan user");
        return redirect()->back()->with("error", "terjadi kesalahan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Akun";
        $user = $this->userService->detailUser($id, array("email", "university", "role_id", "createdAt", "gender", "id"));
        if (is_null($user)) return abort(404);
        return view("pages.dashboard.admin.user.show", compact("title", "user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        if ($request->get("action") && $request->get("action") == "reset-password") return $this->resetPassword($request, $id);

        $title = "Edit Akun";
        $user = $this->userService->detailUser($id, array("id", "email", "university"));
        if (is_null($user)) return abort(404);

        $gender = array("laki-laki", "perempuan");
        return view("pages.dashboard.admin.user.edit", compact("title", "user", "gender"));
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

        if ($request->get("action") && $request->get("action") == "reset-password") return $this->resetPasswordSubmit($request, $id);

        $result = $this->userService->updateUser($request, $id, $request->post("email"), $request->post("gender"), $request->post("university"));

        if (!$result) return redirect()->route("dashboard.admin.user.index")->with("error", "terjadi kesalahan");

        return redirect()->route("dashboard.admin.user.index")->with("success", "sukses mengupdate user");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) return redirect()->route("dashboard.admin.user.index")->with("error", "terjadi kesalahan");

        return redirect()->route("dashboard.admin.user.index")->with("success", "sukses menghapus user");
    }
    private function resetPassword(Request $request, $id)
    {
        $title = "Reset Password";
        $user = $this->userService->detailUser($id, array("id"));
        if (is_null($user)) return abort(404);
        return view("pages.dashboard.admin.user.reset_password", compact("title", "user"));
    }
    private function resetPasswordSubmit(Request $request, $id)
    {
        $result = $this->resetPasswordService->resetPassword($request, $id, $request->post("password"));

        if (!$result) return redirect()->route("dashboard.admin.user.index")->with("error", "terjadi kesalahan");
        return redirect()->route("dashboard.admin.user.index")->with("success", "sukses mengubah password user");
    }
}
