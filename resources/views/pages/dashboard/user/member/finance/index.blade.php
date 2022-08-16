@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        <h1>Pembayaran Kas</h1>
        @include('components.table')
    </div>
@endsection