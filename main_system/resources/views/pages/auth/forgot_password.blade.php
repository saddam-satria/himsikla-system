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
                <form action="{{route("dashboard.auth.password.update") . "?action=password"}}" method="POST" style="width: 100%;">
                    <div class="card card-body">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <input name="token" value="{{Request::get("token")}}" readonly class="form-control">
                        </div>

                        <div class="form-group">
                            <input name="email" value="{{Request::get("email")}}" readonly class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">Password Baru </label>
                            <input name="new_password" id="new_password"  class="form-control" placeholder="********"  type="password">
                        </div>
                        @include('components.form_validation', ["field" => "new_password"])
        
        
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input name="password_confirmation" id="password_confirmation"  class="form-control" placeholder="********"  type="password">
                        </div>
                        @include('components.form_validation', ["field" => "password_confirmation"])
        

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
