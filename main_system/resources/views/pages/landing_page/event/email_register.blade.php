@extends('layouts.landing_page')

@section('landing_page-content')
    <div style="margin: 5rem 0px">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                </div>
                <div class="col-12 col-md-6">
                   
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-5 d-flex flex-column align-items-center">
                            <img src="{{asset("android-chrome-192x192.png")}}" width="120" alt="">
                            <div class="pt-3">
                                <span class="text-lg text-bold text-capitalize">Email Pendaftaran</span>
                            </div>
                        </div>
                        @include('components.alert')
                        <form action="{{route("event.register.create", $event->id)}}" method="GET" style="width: 100%;">
                            <div class="card card-body">
                                <div class="form-group">
                                    <label for="email">Email Anda</label><span class="text-danger">*</span>
                                    <input style="width: 100%;" value="{{old("email")}}" type="text" id="email" name="email" class="form-control rounded"  placeholder="Masukkan Email Anda...">
                                </div>
                                @include('components.form_validation', ["field" => "email"])
                                <div style="width: 100%;">
                                    <button type="submit" style="width: 100%;" class="btn btn-primary btn-md">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
