
@extends('layouts.main')

@section('content')

    @include('components.navbar')
        <section class="content my-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%">
                            {{-- <img src="{{asset("android-chrome-192x192.png")}}" width="80" alt="HIMSI KLA"> --}}
                            <span class="text-bold" style="font-size: 10em; color: #101248;">401</span>
                            <span class="text-md text-lg" style="color: #4449ae; font-weight: 600">Anda Tidak Memiliki Akses</span>
                            <span class="text-md text-md text-center " style="color: #6b6b6b98;">HIMSI KLA SMART SYSTEM menyatakan anda tidak memiliki akses pada halaman ini, gunakan fitur yang ada pada sistem</span>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div style="width: 100%;">
                            <img src="{{asset("assets/img/casual-life-3d-24.png")}}"  style="object-fit: cover; width: 100%;height: 100%;" alt="Casual Life">
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex flex-column align-items-center my-5">
                    @if (!is_null(auth()->user()) && !is_null(auth()->user()->member))
                        <div class="py-3">
                            <a href="{{url("/dashboard")}}" class="btn btn-primary btn-md text-md text-capitalize">
                                <i class="fas fa-arrow-left"></i> Kembali Ke Dashboard
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
       
@endsection

