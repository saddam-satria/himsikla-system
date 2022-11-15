@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Data Absensi Pertemuan Anggota</h1>
        @include('components.export_button', array("pdf" => route("dashboard.admin.meet_absence.member.export"), "excel" => route("dashboard.admin.meet_absence.member.export") . "?action=excel"))
        @include('components.table')
    </div>
@endsection