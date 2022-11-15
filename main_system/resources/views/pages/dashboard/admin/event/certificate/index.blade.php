@extends('layouts.dashboard')

@section('dashboard-content')

    @include('components.alert')
    <div class="container-fluid">
        <div class="py-2">
            <h1>Daftar Sertifikat</h1>
        </div>
        @include('components.table')
    </div>
@endsection