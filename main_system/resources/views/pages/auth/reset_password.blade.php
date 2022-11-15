@extends('layouts.main')

@include('components.navbar')
@section('content')
 <div class="my-5">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
        </div>
        <div class="col-12 col-md-6">
           
            <div class="d-flex flex-column align-items-center">
                <div class="mb-5 d-flex flex-column align-items-center">
                    <img src="{{asset("android-chrome-192x192.png")}}" width="120" alt="">
                    <div class="pt-3">
                        <span class="text-lg text-bold text-capitalize">Reset Password</span>
                    </div>
                </div>
                <form action="{{route("dashboard.auth.password.edit")}}" method="GET" style="width: 100%;">
                    <div class="card card-body">
                        @csrf
                        @method("GET")
                        <div class="form-group">
                            <label for="email">Email Anda</label><span class="text-danger">*</span>
                            <input style="width: 100%;" value="{{old("email")}}" type="text" id="email" name="email" class="form-control rounded"  placeholder="Masukkan Email Anda...">
                        </div>
                        @include('components.form_validation', ["field" => "email"])

                        <div class="form-group">
                            <label for="token">Token Anda</label><span class="text-danger">*</span>
                            <input style="width: 100%;" value="{{old("token")}}" type="text" id="token" name="token" class="form-control rounded"  placeholder="Masukkan token Anda...">
                        </div>
                        @include('components.form_validation', ["field" => "token"])

                        <div style="width: 100%;">
                            <button type="submit" style="width: 100%;" class="btn btn-primary btn-md">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
  </div>
 </div>
@endsection
