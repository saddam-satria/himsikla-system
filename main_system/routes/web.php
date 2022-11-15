<?php

use App\Http\Controllers\auth\forgotPasswordController;
use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\auth\logoutController;
// use App\Http\Controllers\auth\redirectController;
use App\Http\Controllers\dashboard\admin\alumniController;
use App\Http\Controllers\dashboard\admin\balanceSheetController;
use App\Http\Controllers\dashboard\admin\detailFinanceController;
use App\Http\Controllers\dashboard\admin\documentController;
use App\Http\Controllers\dashboard\admin\eventAbsenceController;
use App\Http\Controllers\dashboard\admin\eventController;
use App\Http\Controllers\dashboard\admin\financeController;
use App\Http\Controllers\dashboard\admin\galleryController;
use App\Http\Controllers\dashboard\admin\incomeController;
use App\Http\Controllers\dashboard\admin\MeetAbsenceController;
use App\Http\Controllers\dashboard\admin\meetController;
use App\Http\Controllers\dashboard\admin\meetNoteController;
use App\Http\Controllers\dashboard\admin\memberController;
use App\Http\Controllers\dashboard\admin\noteController;
use App\Http\Controllers\dashboard\admin\outcomeController;
use App\Http\Controllers\dashboard\admin\userController;
use App\Http\Controllers\dashboard\dashboardController;
use App\Http\Controllers\dashboard\member\documentController as MemberDocumentController;
use App\Http\Controllers\dashboard\member\eventController as MemberEventController;
use App\Http\Controllers\dashboard\member\financeController as MemberFinanceController;
use App\Http\Controllers\dashboard\member\meetController as MemberMeetController;
use App\Http\Controllers\dashboard\member\profileController;
use App\Http\Controllers\dashboard\user\profileController as UserProfileController;
use App\Http\Controllers\landingPageController;
use Illuminate\Support\Facades\Route;



Route::prefix("/")->group(function () {
    Route::get("/", [landingPageController::class, "homepage"])->name("homepage");
    Route::get("/about", [landingPageController::class, "about"])->name("about");
    Route::get("/gallery", [landingPageController::class, "gallery"])->name("gallery");
    Route::get("/events", [landingPageController::class, "events"])->name("events");
    Route::get("/event/{id}", [landingPageController::class, "event"])->name("event");
    Route::get("/event/{id}/register/email", [landingPageController::class, "emailRegister"])->name("event.register.email");
    Route::get("/event/{id}/register", [landingPageController::class, "createRegister"])->name("event.register.create");
    Route::post("/event/{id}/register", [landingPageController::class, "register"])->name("event.register");
    Route::get("/event-absence", [landingPageController::class, "createAbsence"])->name("event.absence.create");
    Route::post("/event-absence", [landingPageController::class, "absence"])->name("event.absence");


    Route::get("/password/reset", [forgotPasswordController::class, 'resetToken'])->name("dashboard.auth.reset_token");
    Route::get("/password/change-password", [forgotPasswordController::class, 'editPassword'])->name("dashboard.auth.password.edit");
    Route::post("/password/change-password", [forgotPasswordController::class, 'updatePassword'])->name("dashboard.auth.password.update");
});

Route::middleware(array("loggedIn"))->group(function () {

    Route::get("/profile/user", [UserProfileController::class, 'index'])->name("dashboard.user.profile");
    Route::get("/profile/user/edit", [UserProfileController::class, 'edit'])->name("dashboard.user.profile.edit");
    Route::post("/profile/user/edit", [UserProfileController::class, 'update'])->name("dashboard.user.profile.update");



    Route::middleware(array("isMember"))->group(function () {
        Route::prefix("/dashboard")->group(function () {

            Route::get('/', [dashboardController::class, 'index']);

            Route::prefix("/admin")->group(function () {

                Route::middleware(array("isLeader"))->group(function () {
                    Route::resource("user", userController::class)->names("dashboard.admin.user");
                    Route::resource("member", memberController::class)->names("dashboard.admin.member");
                    Route::post("export", [memberController::class, "export"])->name("dashboard.admin.member.export");
                });

                Route::middleware(array("isChamberlain"))->group(function () {
                    Route::prefix("finance-management")->group(function () {
                        Route::resource("finance", financeController::class)->names("dashboard.admin.finance");
                        Route::post("finance/{finance}/export", [financeController::class, "export"])->name("dashboard.admin.finance.export");
                        Route::resource("income", incomeController::class)->names("dashboard.admin.income");
                        Route::post("incomes/export", [incomeController::class, "export"])->name("dashboard.admin.income.export");
                        Route::resource("outcome", outcomeController::class)->names("dashboard.admin.outcome");
                        Route::post("outcomes/export", [outcomeController::class, "export"])->name("dashboard.admin.outcome.export");
                        Route::resource("balance-sheet", balanceSheetController::class)->names("dashboard.admin.balance_sheet");
                        Route::post("balance-sheets/export", [balanceSheetController::class, "export"])->name("dashboard.admin.balance_sheet.export");
                        Route::resource("detail-finance", detailFinanceController::class)->names("dashboard.admin.detail_finance")->except(array("index"));
                    });
                });

                Route::middleware(array("isSecretary"))->group(function () {
                    Route::resource("event-note", noteController::class)->names("dashboard.admin.event_note")->parameters(array("event_note" => "event_note"));
                    Route::resource("meet-note", meetNoteController::class)->names("dashboard.admin.meet_note")->parameters(array("meet_note" => "meet_note"));
                    Route::resource("document", documentController::class)->names("dashboard.admin.document");
                });

                Route::middleware(array("isRsdm"))->group(function () {
                    Route::resource("meet", meetController::class)->names("dashboard.admin.meet");
                    Route::resource("meet-absence", MeetAbsenceController::class)->names("dashboard.admin.meet_absence");
                    Route::get("member-absence", [MeetAbsenceController::class, 'members'])->name("dashboard.admin.meet_absence.member");
                    Route::post("meet-absence/{meet}/export", [MeetAbsenceController::class, "export"])->name("dashboard.admin.meet_absence.export");
                    Route::post("member-absence/export", [MeetAbsenceController::class, 'exportByMember'])->name("dashboard.admin.meet_absence.member.export");
                    Route::resource("event-absence", eventAbsenceController::class)->names("dashboard.admin.event_absence");
                    Route::post("event-absence/{event}/export", [eventAbsenceController::class, "export"])->name("dashboard.admin.event_absence.export");
                    Route::post("event-absence/{event}/paid-confirmation", [eventAbsenceController::class, "paid"])->name("dashboard.admin.event_absence.paid");
                    Route::resource("event", eventController::class)->names("dashboard.admin.event");
                    Route::resource("alumni", alumniController::class)->names("dashboard.admin.alumni")->parameters(array("alumni" => "alumni"));
                });

                Route::middleware(array("isKominfo"))->group(function () {
                    Route::get("event/create/certificate", [eventController::class, 'createCertificate'])->name("dashboard.admin.event.certificate.create");
                    Route::post("event/create/certificate", [eventController::class, 'storeCertificate'])->name("dashboard.admin.event.certificate.store");
                    Route::delete("event/delete/certificate/{certificate:id}", [eventController::class, 'destroyCertificate'])->name("dashboard.admin.event.certificate.destroy");
                    Route::resource("gallery", galleryController::class)->names("dashboard.admin.gallery")->except(array("show", "edit", "update"));
                });
            });

            Route::prefix("/user")->group(function () {
                Route::prefix("/member")->group(function () {
                    Route::get("/", [profileController::class, 'index'])->name("dashboard.user.member.profile");
                    Route::get("/edit", [profileController::class, 'edit'])->name("dashboard.user.member.profile.edit");
                    Route::post("/edit", [profileController::class, 'update'])->name("dashboard.user.member.profile.update");

                    Route::get("/meet-absence/{hash}", [MemberMeetController::class, 'present'])->name("dashboard.user.member.present");
                    Route::get("/event-absence/{hash}", [MemberEventController::class, 'present'])->name("dashboard.user.member.event_present");
                    Route::get("scanner", [profileController::class, 'scanner'])->name("dashboard.user.member.scanner");
                    Route::get("/event-absence", [MemberEventController::class, 'absence'])->name("dashboard.user.member.event.absence");
                    Route::get("/meet-absence", [MemberMeetController::class, 'absence'])->name("dashboard.user.member.absence");
                    Route::get("/meet", [MemberMeetController::class, 'index'])->name("dashboard.user.member.meet.index");
                    Route::get("/meet/{meet}", [MemberMeetController::class, 'show'])->name("dashboard.user.member.meet.show");
                    Route::get("/division", [profileController::class, 'division'])->name("dashboard.user.member.division.index");
                    Route::get("/event", [MemberEventController::class, "index"])->name("dashboard.user.member.event.index");
                    Route::get("/event/{event}", [MemberEventController::class, "show"])->name("dashboard.user.member.event.show");
                    Route::get("/finance", [MemberFinanceController::class, "index"])->name("dashboard.member.finance.index");
                    Route::get("/finance/history", [MemberFinanceController::class, "history"])->name("dashboard.member.finance.history");
                    Route::post("/finance/history/export", [MemberFinanceController::class, "export"])->name("dashboard.member.finance.history.export");
                    Route::get("/finance/pay", [MemberFinanceController::class, "create"])->name("dashboard.member.finance.create");
                    Route::post("/finance/pay", [MemberFinanceController::class, "payment"])->name("dashboard.member.finance.store");
                    Route::get("/documents", [MemberDocumentController::class, 'index'])->name("dashboard.user.member.document");
                    Route::post("/document/{url}/download", [MemberDocumentController::class, 'download'])->name("dashboard.user.member.document.download");
                });
            });
        });
    });

    Route::post("/logout", [logoutController::class, 'logout'])->name("auth.logout");
});

Route::middleware(array("alreadyLogged"))->group(function () {
    Route::get("/login", [loginController::class, 'index'])->name("auth.login.index");
    Route::post("/login", [loginController::class, 'login'])->name("auth.login");
});

// Route::get("/redirect", [redirectController::class, 'redirect'])->name("auth.redirect");
