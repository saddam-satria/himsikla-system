@extends('layouts.main')


@section('content')
 <div class="login-page bg-light">
  <div class="container">
   
   <div class="bg-light p-5" >
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <img style="border: none;" class="img-fluid img-thumbnail bg-transparent" src="{{asset("assets/img/casual-life-3d-boy-sitting-at-the-desk-with-open-book.png")}}" alt="Organization">
      </div>
      <div class="col-sm-12 col-md-6">

        <div class="py-2">
          <h4 class="text-uppercase" style="letter-spacing: 0.1ch">
            welcome to login system
          </h4>
         
        </div>

        @if (session()->get("errors"))
          <div class="alert alert-danger" role="alert">
             <span class="text-capitalize">Terjadi Kesalahan, Mohon Coba Lagi Dan Periksa kembali</span>
          </div>
        @endif
        
        @include('components.alert')
        
        <form method="POST" action="{{route("auth.login")}}">
          @csrf
          @method("POST")
          <div class="card bg-light" style="box-shadow: none;">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input name="email" type="text" class="form-control"  placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input name="password" type="password" class="form-control" placeholder="Password">
            </div>

            <span style="font-size: 0.9em"><a href="{{route("dashboard.auth.reset_token")}}" class="text-decoration-none">Lupa Password ?</a></span>
            
            <div class="py-2">
              <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
          </div>
        </form>
       <div class="d-flex flex-column">
       
        <span style="font-size: 12px;" class="text-danger">*login dengan akun yang sudah dibuat</span>
        <span style="font-size: 12px;" class="text-danger">*password awal adalah hello123</span>
       </div>
      </div>
    </div>
   </div>
  </div>
 </div>
@endsection
