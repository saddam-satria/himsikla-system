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
                  <form method="POST" action="{{route("dashboard.admin.user.update", $user->id)}}">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                      <div class="form-group">
                        <label for="email">Email address</label><span class="text-danger">*</span>
                        <input value="{{$user->email}}" type="text" name="email" id="email" class="form-control"  placeholder="Alamat Email">
                      </div>
                      @include('components.form_validation', ["field" => "email"])

                      <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="custom-select">
                            @foreach ($gender as $gender)
                              <option class="text-capitalize" value="{{$gender}}">{{$gender}}</option>
                            @endforeach
                          </select>
                      </div>

                      <div class="form-group">
                        <label for="university">universitas/instansi/perusahaan</label><span class="text-danger">*</span>
                        <input  type="text" name="university" value="{{$user->university}}" id="university" class="form-control" placeholder="University" >
                      </div>
                      @include('components.form_validation', ["field" => "university"])

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
