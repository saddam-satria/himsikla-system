
@extends('layouts.dashboard')

@section('dashboard-content')

        <div class="container-fluid">
          @include('components.alert')

            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                              
                                <div class="form-group">
                                    <label >ID User</label>
                                    <input  type="text"  class="form-control" disabled value="{{$user->id ? $user->id : "-"}}">
                                  </div>

                                <div class="form-group">
                                  <label >Email User</label>
                                  <input  type="text"  class="form-control" disabled value="{{$user->email ? $user->email : "-"}}">
                                </div>

                                <div class="form-group">
                                  <label >Jenis Kelamin</label>
                                  <input  type="text"  class="form-control" disabled value="{{$user->gender ? $user->gender : "-"}}">
                                </div>
                                
                               

                                <div class="form-group">
                                  <label >University</label>
                                  <input  type="text"  class="form-control" disabled value="{{$user->university ? $user->university : "-"}}">
                                </div>

                                <div class="form-group">
                                    <label >Role User</label>
                                    <input  type="text"  class="form-control" disabled value="{{$user->role_id == 1 ? "anggota" : "tamu"}}">
                                </div>

                                <div class="form-group">
                                  <label >Akun Dibuat</label>
                                  <input  type="text"  class="form-control" disabled value="{{$user->createdAt ? $user->createdAt : "-"}}">
                                </div>

                                

                               
                            </div>
                        </div>
                </div>
                </div>
            </div>
        </div>

@endsection