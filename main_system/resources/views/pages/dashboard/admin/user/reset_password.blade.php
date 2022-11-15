@extends('layouts.dashboard')


@section('dashboard-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form method="POST" action="{{route("dashboard.admin.user.update", $user->id) . "?action=reset-password"}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="password">Password Yang Baru</label><span class="text-danger">*</span>
                        <input type="password" name="password" id="password" class="form-control"  placeholder="Password">
                      </div>
                      @include('components.form_validation', ["field" => "password"])

                      <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Yang Baru</label><span class="text-danger">*</span>
                        <input  type="password" name="password_confirmation"  id="password_confirmation" class="form-control" placeholder="konfirmasi password" >
                      </div>
                      @include('components.form_validation', ["field" => "password_confirmation"])

                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
    
        
            </div>
        </div>
    </div>
@endsection
