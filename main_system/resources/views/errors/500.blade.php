@extends('layouts.main')

@section('content')

    @include('components.navbar')
        <section class="content my-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%">
                            {{-- <img src="{{asset("android-chrome-192x192.png")}}" width="80" alt="HIMSI KLA"> --}}
                            <span class="text-bold" style="font-size: 10em; color: #101248;">500</span>
                            <span class="text-md text-lg" style="color: #4449ae; font-weight: 600">Terjadi Kesalahan Pada Sistem</span>
                            <span class="text-md text-md text-center text-lowercase " style="color: #6b6b6b98;">HIMSI KLA SMART SYSTEM menyatakan sistem sedang terjadi suatu masalah, silahkan kunjungi beberapa saat lagi</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div style="100%;">
                            <img src="{{asset("assets/img/casual-life-3d-24.png")}}"  style="object-fit: cover; width: 100%;height: 100%;" alt="Casual Life">
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
    @endsection
