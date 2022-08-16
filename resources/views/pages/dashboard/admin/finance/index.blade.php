@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Data Kas</h1>
        
        @if (auth()->user()->member->occupation != "ketua")
        <div class="d-flex mt-3">
            <a href="{{route("dashboard.admin.finance.create")}}" class="btn btn-sm btn-primary">Tambah Data</a>
        </div>
        @endif
        @include('components.table')

    </div>
@endsection