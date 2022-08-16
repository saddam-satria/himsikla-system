@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Daftar Notulensi Pertemuan</h1>
        @include('components.table')
    </div>
@endsection