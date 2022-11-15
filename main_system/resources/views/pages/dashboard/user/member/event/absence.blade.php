@extends('layouts.dashboard')

@section('dashboard-content')
    @include('components.alert')
    <div class="container-fluid">
        @include('components.table')
    </div>
@endsection