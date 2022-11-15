@extends('layouts.main')

@section('content')

    @include('components.topbar')

    @include('components.sidebar')

    @include('components.sidebar_right')

    <div class="content-wrapper py-5">
        <section class="content mb-5">
            @yield('dashboard-content')
        </section>
    </div>
    @include('components.footer')
@endsection


