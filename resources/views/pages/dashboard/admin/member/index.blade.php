@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <h1>Daftar Anggota</h1>
        
        @include('components.export_button', ["pdf" => route("dashboard.admin.member.export")])
        @include('components.table')
    </div>
@endsection