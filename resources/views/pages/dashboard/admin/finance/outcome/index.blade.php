@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Data Pengeluaran</h1>
        
        @if (auth()->user()->member->occupation != "ketua")
        <div class="d-flex mt-3">
            <a href="{{route("dashboard.admin.outcome.create")}}" class="btn btn-sm btn-primary mr-2">Tambah Data</a>
            @include('components.export_button', array("pdf" => route("dashboard.admin.outcome.export"), "excel" => route("dashboard.admin.outcome.export"). "?action=excel"))
        </div>
        @endif
        @include('components.table')
    </div>
@endsection