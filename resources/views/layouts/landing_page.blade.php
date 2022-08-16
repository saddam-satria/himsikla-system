@extends('layouts.main')

@push('head')
    <style>
        body{
            background-color: rgb(247, 243, 250);
        }
    </style>
@endpush

@section('content')

    @include('components.navbar')
        <section class="content">
            @yield('landing_page-content')
        </section>
        @include('components.landing_page.footer')
@endsection


